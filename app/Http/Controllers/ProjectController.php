<?php

namespace App\Http\Controllers;

use App\Models\TeamJoinRequest;
use App\Models\TeamUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    private function isImage(Request $request) {
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');

            // Générer un nom unique pour le fichier image
            $imageName = uniqid('image_') . '.' . $image->getClientOriginalExtension();

            // Stocker le fichier image dans le répertoire "public/images"
            $image->storeAs('projects/images', $imageName, 'public');

            return $imageName;
        }
    }

    /**
     * Create a new project
     */
    public function create(Request $request) {

        $image = $this->isImage($request);

        // Store project in database
        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => (isset($image)) ? 'storage/projects/images/' . $image : "storage/projects/images/default.jpg",
            'owner_id' => Auth::id(),
            'status_id' => $request->status
        ]);

        Team::create([
            'name' => $request->title,
            'personal_team' => 1,
            'user_id' => Auth::id(),
            'project_id' => $project->id,
        ]);

        return to_route('project.create.post');
    }

    public function delete(Request $request) {
        if ($request->owner_id == Auth::id()) {
            Project::destroy($request->id);
            Team::where('project_id', $request->id)->delete();
        }
        return to_route('home');
    }

    public function show(int $id) {
        $project = Project::find($id);
        $team = Team::where('project_id', $id)->first();
        $owner_project = User::where('id', $team->user_id)->first();
        $users_id = TeamUser::where('team_id', $team->id)->pluck('user_id')->toArray();
        $users_belongs_project = User::whereIn('id', $users_id)->get();

        $isAlreadyJoinRequest = TeamJoinRequest::where('user_id', Auth::id())->where('team_id', $team->id)->first();

        return view('project.show',[
            'project' => $project,
            'users' => $users_belongs_project,
            'owner' => $owner_project,
            'team' => $team,
            'isAlreadyJoinRequest' => $isAlreadyJoinRequest,
        ]);
    }

    public function showAll() {
        $projects = Project::all();

        return view('welcome', [
            'projects' => $projects
        ]);
    }

    public function update(Request $request) {
        $project = Project::find($request->id);

        $image = $this->isImage($request);

        $statuses = Status::find($project->id);

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => (isset($image)) ? 'storage/projects/images/' . $image : $project->image,
            'status_id' => $request->status
        ]);

        return to_route('home');
    }

    public function updateForm(int $id) {
        $project = Project::find($id);

        $statuses = Status::all();

        return view('project.update', [
            'project' => $project,
            'statuses' => $statuses,
        ]);
    }
}
