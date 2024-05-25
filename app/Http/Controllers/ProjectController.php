<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\TeamJoinRequest;
use App\Models\TeamUser;
use Faker\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Mockery\Exception;
use Intervention\Image\Image;

class ProjectController extends Controller
{
    /**
     * Create a project
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), Project::$rules, Project::$messages);

            if ($validator->fails()) {
                return abort(Response::HTTP_FORBIDDEN);
            }

            $image = $this->isImage($request);
            $project = Project::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => (isset($image)) ? 'storage/projects/images/' . $image : "storage/projects/images/default.png",
                'owner_id' => Auth::id(),
                'status_id' => $request->status_id,
            ]);

            $team = Team::create([
                'name' => $request->title,
                'personal_team' => 1,
                'user_id' => Auth::id(),
                'project_id' => $project->id
            ]);

            $tags = $request->input('tags');
            $tags = explode(',', $tags);

            foreach ($tags as $tag) {
                Tag::create(['name' => $tag, 'project_id' => $project->id]);
            }

            return to_route('project.show', ['id' => $project->id]);
        } catch (\Exception $e) {
            Log::error("Impossible de créer le projet ou l'équipe : " . $e->getMessage());
            return redirect()->back()->dangerBanner(
                __('Une erreur s\'est produite lors de la création du projet.'),
            );
        }
    }

    /**
     * Delete a project
     *
     * @param int $projectId
     * @return RedirectResponse
     */
    public function delete(int $projectId): RedirectResponse|Response
    {
        try {
            $team = Team::where('project_id', $projectId)->firstorFail();
            if (Gate::denies('delete-project', $team)) {
                abort(403);
            }

            Project::destroy($projectId);
            Team::where('project_id', $projectId)->delete();
            Tag::where('project_id', $projectId)->delete();

            return to_route('home');
        } catch (ModelNotFoundException $e) {
            Log::error("Le projet à supprimer n'a pas été trouvé : " . $e->getMessage());
            return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error("Impossible de supprimer le projet :" . $e->getMessage());
            return redirect()->back()->dangerBanner(
                __('Une erreur s\'est produite lors de la suppression du projet.'),
            );
        }
    }


    /**
     * Retrieve a unique project
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id): View|RedirectResponse|Response
    {
        try {
            $project = Project::findOrFail($id);

            $isAlreadyJoinRequest = TeamJoinRequest::where('user_id', Auth::id())->where('team_id', $project->team->id)->first();

            return view('project.show',[
                'project' => $project,
                'users' => $project->team->users,
                'owner' => $project->owner,
                'team' => $project->team,
                'isAlreadyJoinRequest' => $isAlreadyJoinRequest,
                'tags' => $project->tags
            ]);
        } catch (ModelNotFoundException $e) {
            Log::error("Impossible de récupérer les informations du projet : " . $e->getMessage());
            return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error("Une erreur s'est produite lors de la récupération du projet : " . $e->getMessage());
            return redirect()->back()->dangerBanner(
                __('Une erreur s\'est produite lors de la récupération du projet.'),
            );
        }
    }

    /**
     * Retrieve all projects
     *
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        $projects = Project::all();

        return view('welcome', [
            'projects' => $projects
        ]);
    }

    /**
     * Update the project
     *
     * @param Request $request
     * @param int $projectId
     * @return RedirectResponse
     */
    public function update(Request $request, int $projectId): RedirectResponse|Response
    {
        try {
            $team = Team::where('project_id', $projectId)->firstorFail();
            $project = Project::findOrFail($projectId);
            $image = $this->isImage($request);
            $oldTags = Tag::all()->where('project_id', $project->id)->pluck('name')->toArray();
            $newTags = explode(',', $request->tags);

            if (Gate::denies('update-project', $team)) {
                abort(403);
            }

            $validator = Validator::make($request->all(), Project::$rules, Project::$messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $tagsToDelete = array_diff($oldTags, $newTags);
            $tagsToCreate = array_diff($newTags, $oldTags);

            Tag::whereIn('name', $tagsToDelete)->delete();

            foreach ($tagsToCreate as $tagName) {
                if (!empty($tagName)) {
                    Tag::create(['name' => $tagName, 'project_id' => $projectId]);
                }
            }

            $project->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => (isset($image)) ? 'storage/projects/images/' . $image : $project->image,
                'status_id' => $request->status_id
            ]);

            $team->update([
                'name' => $request->title
            ]);

            return redirect()->route('project.show', ['id' => $project->id]);
        } catch (ModelNotFoundException $e) {
            Log::error("Impossible de trouver le projet à modifer :" . $e->getMessage());
            return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error('Impossible de modifier le projet : ' . $e->getMessage());
            return redirect()->back()->dangerBanner(
                __('Une erreur s\'est produite lors de la modification du projet.'),
            );
        }
    }

    /**
     *  Redirect to update form
     *
     * @param int $projectId
     * @return View|RedirectResponse
     */
    public function updateForm(int $projectId): View|RedirectResponse|Response
    {
        try {

            $project = Project::findOrFail($projectId);
            $statuses = Status::all();
            $team = Team::where('project_id', $projectId)->firstOrFail();
            $tags = Tag::all()->where('project_id', $project->id)->pluck('name')->toArray();

            $tags = implode(',', $tags);

            if (Gate::denies('update-project', ['team' => $team])) {
                abort(403);
            }

            return view('project.update', [
                'project' => $project,
                'statuses' => $statuses,
                'tags' => $tags
            ]);
        } catch (ModelNotFoundException $e) {
            Log::error('Le projet n\'a pas été trouvé : ' . $e->getMessage());
            return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error('Le projet n\'a pas été trouvé : ' . $e->getMessage());
            return redirect()->back()->dangerBanner(
                __('Une erreur s\'est produite lors de la récupération du projet.'),
            );
        }
    }

    /**
     * Store the image of the project in the storage
     *
     * @param Request $request
     * @return string|null
     */
    private function isImage(Request $request): string|null
    {
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');

            // Générer un nom unique pour le fichier image
            $imageName = uniqid('image_') . '.' . $image->getClientOriginalExtension();

            $manager = new ImageManager(
                new \Intervention\Image\Drivers\Gd\Driver()
            );
            // Redimensionnement de l'image avant de la stocker
            $resizedImage = $manager->read($image)->resize(500, 500);

            // Stocker le fichier image redimensionné dans le répertoire "public/projects/images"
            Storage::put('public/projects/images/' . $imageName, $resizedImage->encode());

            return $imageName;
        } else {
            return null;
        }
    }
}
