@section('title', 'Projet')
<x-app-layout>
    <div class="antialiased bg-gray-100 min-h-screen text-gray-800">
        <div class="container mx-auto p-8">
            <div class='text-center uppercase text-4xl text-blue-600 font-bold mb-4'>
                {{ $project->title }}
            </div>

            <div class="flex flex-wrap justify-around">
                <!-- Left column for the card with the description -->
                <div class="w-full md:w-8/12 mb-4 md:mb-0">
                    <div class="bg-white rounded-lg p-4 shadow-md">
                        <div class='text-blue-700 font-bold text-xl mb-2'>
                            Description
                        </div>
                        <hr class="my-4 border-t-1 border-gray-300">
                        <p class='text-gray-800 break-words whitespace-pre-line overflow-auto h-[60vh]'>
                            {{ $project->description }}
                        </p>

                        <!-- Section pour afficher les technologies -->
                        <div class="mt-4">
                            <div class="text-blue-700 font-bold text-xl mb-2">
                                Technologies
                            </div>
                            @forelse ($project->tags as $tag)
                                <span class="inline-block bg-blue-500 text-white px-2 py-1 rounded-full mr-2 mb-2">
                                    {{ $tag->name }}
                                </span>
                            @empty
                                <p class="text-gray-500">Aucune technologie associée.</p>
                            @endforelse
                        </div>
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
                                <a href="{{ route('user.show', ['username' => $owner->username]) }}">
                                    {{ $owner->username }}
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
                            <div class="text-blue-700 font-bold text-lg mb-2">Statut</div>
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
                                                <button onclick="openJoinProjectModal()" class="w-full justify-center inline-flex items-center px-4 py-2 border border-yellow-500 text-sm leading-5 font-medium rounded-md text-yellow-500 hover:bg-yellow-100 focus:outline-none focus:border-yellow-600 focus:shadow-outline-yellow active:bg-yellow-200 transition duration-150 ease-in-out">
                                                    Demander à rejoindre le projet
                                                </button>
                                                @include('project.join-project-popup')
                                            @endif
                                        @endunless
                                    @else
                                        <a href="{{ route('teams.show', $project->id) }}" :active="request()->routeIs('teams.show')" class="inline-flex items-center justify-center w-full px-4 py-2 border border-yellow-600 text-sm leading-5 font-medium rounded-md text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 focus:outline-none focus:border-yellow-700 focus:shadow-outline-yellow active:bg-yellow-200 active:text-yellow-700 transition duration-150 ease-in-out">
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
                                    <a href="{{ route("project.update.form", ['id' => $project->id]) }}" class="w-full inline-flex items-center justify-center px-6 py-2 border border-blue-500 text-sm leading-5 font-medium rounded-md text-blue-700 hover:bg-blue-100 focus:outline-none focus:border-blue-600 focus:shadow-outline-blue active:bg-blue-200 transition duration-150 ease-in-out">
                                        Modifier le projet
                                    </a>
                                </div>
                            @endcan

                            @can('delete-project', $team)
                                <div class="w-full">
                                    <button onclick="openDeleteProjectModal()" class="w-full inline-flex items-center justify-center px-6 py-2 border border-red-500 text-sm leading-5 font-medium rounded-md text-red-500 hover:bg-red-100 focus:outline-none focus:border-red-600 focus:shadow-outline-red active:bg-red-200 transition duration-150 ease-in-out">
                                        Supprimer le projet
                                    </button>
                                    @include('project.delete-popup')
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@include('scripts.project-scripts')
