<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;



class DeleteController extends Controller
{
    public function deleteProject(Request $request) {
        if ($request->id_owner == Auth::id()) {
            Project::destroy($request->id);
        }
        return to_route('home');
    }
}
