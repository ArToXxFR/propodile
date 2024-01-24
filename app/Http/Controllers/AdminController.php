<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function listUsers() {
        try {
            $users = User::all();

            return view('admin.users', [
                'users' => $users
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur lors de la récupération des utilisateurs :" . $e->getMessage());
            return redirect()->back()->withErrors(['message' => "Erreur lors de la récupération des utilisateurs."]);
        }
    }

    public function listProjects() {
        try {
            $projects = Project::all();

            return view('admin.projects', [
                'projects' => $projects
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur lors de la récupération des projets :" . $e->getMessage());
            return redirect()->back()->withErrors(['message' => "Erreur lors de la récupération des projets."]);
        }
    }
}
