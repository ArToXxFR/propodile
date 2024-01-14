<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tous les projets</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite('resources/css/app.css')
    </head>
    <body class="antialiased bg-dots-darker bg-center bg-gray-100 text-white">
    @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        <div>
            <div class='text-center  uppercase text-5xl underline text-indigo-600 mb-2'>
                {{ $project->title }}
            </div>
            <div class='text-gray-400'>
                Description : {{ $project->description }}
            </div>
            <!-- List of members -->
            <span class="text-indigo-600">Owner : {{ $owner->name }}</span>
            <div>
                <span class="text-indigo-600">Liste des membres :</span>
                <ul>
                    @if (!$users->isEmpty())
                        @foreach ($users as $user)
                            <li class="text-indigo-600">
                                - {{ $user->name }}
                            </li>
                        @endforeach
                    @else
                        <li class="text-indigo-400"> Aucun membres pour le moment</li>
                    @endif
                </ul>
            </div>

            <!-- Button to delete the project -->
            <div>
                @if ($project->id_owner == Auth::id())
                    <form action="{{ route("project.delete") }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce projet?')">
                        @csrf
                        <input type="hidden" value="{{ $project->id }}" name="id">
                        <input type="hidden" value="{{ $project->id_owner }}" name="id_owner">
                        <button type="submit" class="text-indigo-600">Supprimer le projet</button>
                    </form>

                @endif
            </div>
            <div>
                @if ($project->id_owner == Auth::id())
                    <a href="{{ route("project.update.form", ['id' => $project->id]) }}" class="text-indigo-600">Modifier le projet</a>
                @endif
            </div>
            <!-- Ask to join project / Invite members -->
            <div>
                @if ($project->id_owner != Auth::id())
                    @if (!Auth::user()->belongstoTeam($team))
                        @if (isset($isAlreadyJoinRequest))
                            <div class="text-red-600">
                                Demande en attente
                            </div>
                        @else
                            <form action="{{ route("team.join") }}" method="GET" onsubmit="return confirm('Voulez-vous vraiment demander à rejoindre le projet ?')">
                                @csrf
                                <input type="hidden" value="{{ $project->id }}" name="id">
                                <input type="hidden" value="{{ $project->team_id }}" name="team_id">
                                <button type="submit" class="text-indigo-600">Demander à rejoindre le projet</button>
                            </form>
                        @endif
                    @endif
                @else
                    <a href="{{ route('teams.show', $project->id) }}" :active="request()->routeIs('teams.show')" class="text-indigo-800">Inviter des membres</a>
                @endif
            </div>

        </div>
