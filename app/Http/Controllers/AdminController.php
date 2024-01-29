<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\WithPagination;


class AdminController extends Controller
{
    use WithPagination;
    public function listUsers(): View|RedirectResponse
    {
        try {
            $users = User::paginate(10);

            return view('admin.users', [
                'users' =>$users,
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur lors de la récupération des utilisateurs :" . $e->getMessage());
            return redirect()->back()->withErrors(['message' => "Erreur lors de la récupération des utilisateurs."]);
        }
    }

    public function listBannedUsers(): View|RedirectResponse
    {
        try {
            $users = User::where('banned', 1)->paginate(10);

            return view('admin.users-banned', [
                'users' => $users,
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur lors de la récupération des utilisateurs bannis :" . $e->getMessage());
            return redirect()->back()->withErrors(['message' => "Erreur lors de la récupération des utilisateurs bannis."]);
        }
    }

    public function listProjects(): View|RedirectResponse
    {
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

    public function ban(Request $request, int $userId): RedirectResponse
    {
        try {
            $user = User::find($userId);

            $user->update([
                'banned' => true,
                'banned_until' => $request->date
            ]);

            return redirect()->back()->with(['message' => 'L\'utilisateur a bien été banni.']);
        } catch (\Exception $e) {
            Log::error("Impossible de bannir l'utilisateur :" . $e->getMessage());
            return redirect()->back()->withErrors(['message' => "Impossible de bannir l'utilisateur."]);
        }
    }

    public function unban(int $userId): RedirectResponse
    {
        try {
            $user = User::find($userId);

            $user->update([
                'banned' => false,
                'banned_until' => null
            ]);

            return redirect()->back()->with(['message' => 'L\'utilisateur a bien été débanni.']);
        } catch (\Exception $e) {
            Log::error("Impossible de débannir l'utilisateur :" . $e->getMessage());
            return redirect()->back()->withErrors(['message' => "Impossible de débannir l'utilisateur."]);
        }
    }

    public function delete(int $userId): RedirectResponse
    {
        try {
            $user = User::find($userId);

            $user->delete();

            return redirect()->back()->with(['message' => 'L\'utilisateur a bien été supprimé.']);
        } catch (\Exception $e) {
            Log::error("Impossible de supprimer l'utilisateur :" . $e->getMessage());
            return redirect()->back()->withErrors(['message' => "Impossible de supprimer l'utilisateur."]);
        }
    }
}
