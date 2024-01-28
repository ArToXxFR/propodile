<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function listUsers() {
        try {
            $users = User::paginate(10);

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
            $projects = Project::paginate(10);

            return view('admin.projects', [
                'projects' => $projects,
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur lors de la récupération des projets :" . $e->getMessage());
            return redirect()->back()->withErrors(['message' => "Erreur lors de la récupération des projets."]);
        }
    }

    public function dashboard(): View|RedirectResponse
    {
        try {
            $projects = Project::paginate(5);
            $users = User::paginate(5);

            return view('admin.dashboard', [
                'projects' => $projects,
                'users' => $users,
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur lors de la récupération du dashboard :" . $e->getMessage());
            return redirect()->back()->withErrors(['message' => "Erreur lors de la récupération du dashboard."]);
        }
    }

    public function ban(Request $request): RedirectResponse
    {
        try {
            $user = User::find($request->id);

            $user->update([
                'banned' => true,
                'banned_until', $request->date
            ]);

            return redirect()->back()->with(['message' => 'L\'utilisateur a bien été banni.']);
        } catch (\Exception $e) {
            Log::error("Impossible de bannir l'utilisateur :" . $e->getMessage());
            return redirect()->back()->withErrors(['message' => "Impossible de bannir l'utilisateur."]);
        }
    }
}
