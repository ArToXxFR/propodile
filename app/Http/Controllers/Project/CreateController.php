<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{

    /**
     * Create a new project
     */
    public function createProject(Request $request) {
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Path to store the file
            $path = $request->file('image')->store('public/projects/images');

            // Store project in database
            Project::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $path,
                'id_owner' => Auth::id(),
            ]);

        } else {
            // Store project with default image
            Project::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => "public/projects/images/default.jpg",
                'id_owner' => Auth::id(),
            ]);

            Team::create([
                'name' => $request->title,
                'personal_team' => Auth::id(),
                'user_id' => Auth::id()
            ]);
        }
        return to_route('project.create.post');
    }
}
