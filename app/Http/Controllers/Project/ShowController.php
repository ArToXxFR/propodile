<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ShowController extends Controller
{
    public function showProject(int $id) {
        $project = Project::find($id);

        return view('project.show',[
            'project' => $project,
            'user_id' => Auth::id(),
        ]);
    }

    public function showAll() {
        $projects = Project::all();

        return view('welcome', [
            'projects' => $projects,
        ]);
    }
}
