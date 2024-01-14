<?php

namespace App\Http\Controllers;

use App\Actions\Jetstream\AddTeamMember;
use App\Models\Team;
use App\Models\TeamJoinRequest;
use App\Mail\MailJoinRequest;
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
            'email' => Auth::user()->email,
            'team_id' => $team->id,
        ]);

        Mail::to($owner->email)->send(new MailJoinRequest($user->name));

        return to_route('home')->with('status', 'La demande a bien été envoyée.');
    }

    public function acceptRequest(AddTeamMember $addTeamMember) {
        $request = TeamJoinRequest::find($id);

        $addTeamMember->($request->team_id, $request->email)
    }
}
