<?php

namespace App\Http\Controllers;

use App\Models\TeamUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Create a new project
     */
    public function create(Request $request) {
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');

            // Générer un nom unique pour le fichier image
            $imageName = uniqid('image_') . '.' . $image->getClientOriginalExtension();

            // Stocker le fichier image dans le répertoire "public/images"
            $image->storeAs('projects/images', $imageName, 'public');
        }
        // Store project in database
        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => (isset($image)) ? 'storage/projects/images/' . $imageName : "storage/projects/images/default.jpg",
            'id_owner' => Auth::id(),
        ]);

        Team::create([
            'name' => $request->title,
            'personal_team' => 1,
            'user_id' => Auth::id(),
            'project_id' => $project->id
        ]);

        return to_route('project.create.post');
    }

    public function delete(Request $request) {
        if ($request->id_owner == Auth::id()) {
            Project::destroy($request->id);
            Team::where('project_id', $request->id)->delete();
        }
        return to_route('home');
    }

    public function show(int $id) {
        $project = Project::find($id);
        $team = Team::where('project_id', $id)->first();
        $owner = User::where('id', $team->user_id)->first();
        $users_id = TeamUser::where('team_id', $team->id)->pluck('user_id')->toArray();
        $users = User::whereIn('id', $users_id)->get();
        
        return view('project.show',[
            'project' => $project,
            'user_id' => Auth::id(),
            'users' => $users,
            'owner' => $owner
        ]);
    }

    public function showAll() {
        $projects = Project::all();

        return view('welcome', [
            'projects' => $projects
        ]);
    }
}
