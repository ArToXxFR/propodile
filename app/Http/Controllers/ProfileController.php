<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function show(string $username)
    {
        try {
            $user = User::where('username', $username)->firstOrFail();
            $grade = Grade::find($user->grade_id);

            return view('profile.user', [
                'user' => $user,
                'grade' => $grade
            ]);
        } catch (ModelNotFoundException $e) {
            Log::error("Utilisateur non trouvé : " . $e->getMessage());
            return abort(404);
        } catch (\Exception $e) {
            Log::error("Impossible de trouver l'utilisateur :" . $e->getMessage());
            return redirect()->back()->withErrors("Impossible de trouver l'utilisateur.");
        }
    }
}
