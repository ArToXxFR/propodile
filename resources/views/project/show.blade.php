<x-app-layout>
    <div class="antialiased bg-gray-100 h-screen text-gray-800">
        @if (Route::has('login'))
            <div class="fixed top-0 right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-blue-600 hover:text-blue-800 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-800 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-blue-600 hover:text-blue-800 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="container mx-auto p-8">
            <div class='text-center uppercase text-4xl text-blue-600 font-bold mb-4'>
                {{ $project->title }}
            </div>

            <div class="flex flex-wrap h-5/6 justify-around">
                <!-- Left column for the card with the description -->
                <div class="w-full md:w-8/12 mb-4 md:mb-0">
                    <div class="bg-white rounded-lg p-4 shadow-md h-full">
                        <div class='text-blue-700 font-bold text-xl mb-2'>
                            Description
                        </div>
                        <hr class="my-4 border-t-1 border-gray-300">
                        <p class='text-gray-800 break-words whitespace-pre-line overflow-auto h-[60vh]'>
                        {{ $project->description }}
                        </p>
                    </div>
                </div>

                <!-- Right column for the other information -->
                <div class="w-full h-full md:w-3/12">
                    <div class="bg-white rounded-lg p-4 shadow-md">
                        <div class="w-full flex flew-row items-center justify-center">
                            <div class="bg-gray-200 rounded-lg p-4">
                                <img src="{{ asset("storage/projects/images/" . basename($project->image)) }}" alt="" class="w-full h-auto rounded-lg">
                            </div>
                        </div>
                        <!-- Chef du projet -->
                        <div class="mt-4 text-center">
                            <span class="text-blue-700 font-bold text-xl mb-2">Propriétaire</span>
                            <div class="text-blue-800 font-extrabold">
                                <a>
                                    <a href="{{ route('user.show', ['username' => $owner->username]) }}">
                                        {{ $owner->username }}
                                    </a>
                                </a>
                            </div>
                        </div>

                        <!-- Liste des membres du projet -->
                        <div class="mt-4 text-center">
                            <span class="text-blue-700 font-bold text-xl mb-2">Liste des membres</span>
                            <ul class="list-disc list-inside mt-2">
                                @forelse ($users as $user)
                                    <li class="text-blue-800">
                                        <a href="{{ route('user.show', ['username' => $user->username]) }}">
                                            {{ $user->username }}
                                        </a>
                                    </li>
                                @empty
                                    <li class="text-blue-400">Aucun membre pour le moment</li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Statut du projet -->
                        <div class="mt-6 text-center">
                            <div class="text-blue-700 font-bold text-lg mb-2">Statut :</div>
                            @switch($project->status_id)
                                @case(1)
                                    <span class="inline-block px-8 py-2 bg-green-500 text-white rounded-full">
                                        {{ $project->status->name }}
                                    </span>
                                    @break
                                @case(2)
                                    <span class="inline-block px-8 py-2 bg-red-500 text-white rounded-full">
                                        {{ $project->status->name }}
                                    </span>
                                    @break
                                @case(3)
                                    <span class="inline-block px-8 py-2 bg-indigo-500 text-white rounded-full">
                                        {{ $project->status->name }}
                                    </span>
                                    @break
                            @endswitch
                        </div>

                        <!-- Demande de rejoindre le projet / Inviter des membres -->
                        <div class="w-full space-y-2">
                            <div class="mt-6">
                                @if (Auth::check())
                                    @cannot('invite-member-project', $team)
                                        @unless(Auth::user()->belongsToTeam($team))
                                            @if (isset($isAlreadyJoinRequest))
                                                <div class="text-center text-red-500 font-bold py-2 bg-red-100 rounded-md">
                                                    Demande en attente
                                                </div>
                                            @else
                                                <form action="{{ route("team.join") }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir demander à rejoindre le projet ?')">
                                                    @csrf
                                                    <input type="hidden" value="{{ $project->id }}" name="id">
                                                    <input type="hidden" value="{{ $project->team_id }}" name="team_id">
                                                    <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-2 border border-yellow-500 text-sm leading-5 font-medium rounded-md text-yellow-500 hover:bg-yellow-100 focus:outline-none focus:border-yellow-600 focus:shadow-outline-yellow active:bg-yellow-200 transition duration-150 ease-in-out">
                                                        Demander à rejoindre le projet
                                                    </button>
                                                </form>
                                            @endif
                                        @endunless
                                    @else
                                        <a href="{{ route('teams.show', $project->id) }}" :active="request()->routeIs('teams.show')" class="inline-flex items-center justify-center w-full px-4 py-2 border border-yellow-500 text-sm leading-5 font-medium rounded-md text-yellow-500 hover:bg-yellow-100 hover:text-yellow-600 focus:outline-none focus:border-yellow-600 focus:shadow-outline-yellow active:bg-yellow-200 active:text-yellow-600 transition duration-150 ease-in-out">
                                            Gérer les membres
                                        </a>
                                    @endcannot
                                @else
                                    <div class="mt-6 p-4 bg-gray-100 border border-gray-300 text-gray-700 rounded-md">
                                        <span class="font-semibold">Info :</span> Vous devez être connecté pour interagir avec le projet.
                                    </div>
                                @endif
                            </div>

                            <!-- Boutons pour supprimer et modifier le projet -->
                            @can('update-project', $team)
                                <div class="w-full mx-auto">
                                    <a href="{{ route("project.update.form", ['id' => $project->id]) }}" class="w-full inline-flex items-center justify-center px-6 py-2 border border-yellow-500 text-sm leading-5 font-medium rounded-md text-yellow-500 hover:bg-yellow-100 focus:outline-none focus:border-yellow-600 focus:shadow-outline-yellow active:bg-yellow-200 transition duration-150 ease-in-out">
                                        Modifier le projet
                                    </a>
                                </div>
                            @endcan

                            @can('delete-project', $team)
                                <div class="w-full">
                                    <form action="{{ route("project.delete", ['id' => $project->id]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-2 border border-red-500 text-sm leading-5 font-medium rounded-md text-red-500 hover:bg-red-100 focus:outline-none focus:border-red-600 focus:shadow-outline-red active:bg-red-200 transition duration-150 ease-in-out">
                                            Supprimer le projet
                                        </button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
