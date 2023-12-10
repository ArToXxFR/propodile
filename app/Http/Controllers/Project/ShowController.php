<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function showProject(int $id) {
        $project = Project::find($id);

        return view('project.show',[
            'project' => $project
        ]);
    }
}
