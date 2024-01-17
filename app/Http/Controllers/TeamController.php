<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamJoinRequest;
use App\Mail\MailJoinRequest;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function sendInvitation(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), Team::$rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::findOrFail(Auth::id());
            $team = Team::where('project_id', $request->id)->firstOrFail();
            $owner = User::where('id', $team->user_id)->firstOrFail();

            TeamJoinRequest::create([
                'user_id' => $user->id,
                'team_id' => $team->id,
            ]);
            try {
                Mail::to($owner->email)->send(new MailJoinRequest($user->name, $team->id));
            } catch (\Exception $e) {
                Log::error("Impossible d'envoyer le mail : " . $e->getMessage());
                return redirect()->back()->withErrors(['message' => "Le mail n'a pas pu être envoyé."]);
            }

                return to_route('home')->with('status', 'La demande a bien été envoyée.');
        } catch (ModelNotFoundException $e) {
            Log::error("Utilisateur ou Equipe non trouvés : " . $e->getMessage());
            return redirect()->back()->withErrors(['message' => 'L\'invitation n\'a pas pu être envoyée.']);
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de l'invitation :" . $e->getMessage());
            return redirect()->back()->withErrors(['message' => 'Erreur lors de l\'envoi de l\'invitation .']);
        }
    }

    public function acceptInvitation(int $team_id): RedirectResponse
    {
        try {
            $request = TeamJoinRequest::where('team_id', $team_id)->firstOrFail();

            $user = User::findOrFail(Auth::id());
            $team = Team::findOrFail($team_id);

            Gate::forUser($user)->authorize('addTeamMember', $team);

            TeamUser::create([
                'user_id' => $request->user_id,
                'team_id' => $request->team_id,
                'role' => 'editor'
            ]);

            $request->delete();

            return redirect(config('fortify.home'))->banner(
                __('Bravo ! Vous venez d\'accepter l\'invitation !'),
            );
        } catch (ModelNotFoundException $e) {
            Log::error("Invitation non trouvée : " . $e->getMessage());
            return redirect()->back()->withErrors(['message' => 'L\'invitation n\'a pas été trouvée.']);
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'acceptation de l'invitation :" . $e->getMessage());
            return redirect()->back()->withErrors(['message' => 'Erreur lors de l\'acceptation de l\'invitation .']);
        }
    }
}
