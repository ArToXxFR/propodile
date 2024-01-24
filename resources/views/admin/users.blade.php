@foreach ($users as $user)
<div>
    {{ $user->firstname }}
    {{ $user->lastname }}
    <a href="{{ route('user.show', ['username' => $user->username])}}">Voir le profile</a>
    <a href="#">Bannir</a>
    {{ $user->role }}
    nb teams :
    {{ $user->allTeams()->count() }}
</div>
@endforeach