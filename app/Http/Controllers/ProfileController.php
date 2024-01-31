<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(string $username): View|Response|RedirectResponse
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
            return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
        }
    }
}
