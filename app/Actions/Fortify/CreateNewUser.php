<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:50', 'unique:users', 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'grade_id' => ['required'],
            'description' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'username' => $input['username'],
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'grade_id' => $input['grade_id'],
                'description' => $input['description'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'profile_photo_path' => 'profile-photos/default.png',
            ]), function (User $user) {
                // $this->createTeam($user);
            });
        });
    }

    /**
     * Create a personal team for the user.
     */
    // protected function createTeam(User $user): void
    // {
    //     $user->ownedTeams()->save(Team::forceCreate([
    //         'user_id' => $user->id,
    //         'name' => explode(' ', $user->name, 2)[0]."'s Team",
    //         'personal_team' => true,
    //     ]));
    // }
}
