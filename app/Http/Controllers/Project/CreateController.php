<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{

    /**
     * Create a new project
     */
    public function createProject(Request $request) {
        Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'id_owner' => Auth::id()
        ]);
        return to_route('project.create.post');
    }
}
