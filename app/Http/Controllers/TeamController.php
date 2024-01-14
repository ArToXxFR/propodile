<?php

namespace App\Http\Controllers;

use App\Actions\Jetstream\AddTeamMember;
use App\Models\Team;
use App\Models\TeamJoinRequest;
use App\Mail\MailJoinRequest;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TeamController extends Controller
{
    public function joinRequest(Request $request) {
        
        $user = User::find(Auth::id());
        $team = Team::where('project_id', $request->id)->first();
        $owner = User::where('id', $team->user_id)->first();

        TeamJoinRequest::create([
            'user_id' => $user->id,
            'team_id' => $team->id,
        ]);

        Mail::to($owner->email)->send(new MailJoinRequest($user->name, $team->id));

        return to_route('home')->with('status', 'La demande a bien été envoyée.');
    }

    public function acceptRequest(int $team_id) {
        
        $request = TeamJoinRequest::where('team_id', $team_id)->firstOrFail();

        TeamUser::create([
            'user_id' => $request->user_id,
            'team_id' => $request->team_id,
        ]);

        $request->delete();

        return redirect(config('fortify.home'))->banner(
            __('Great! You have accepted the request !'),
        );
    }
}
