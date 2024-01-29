@section('title', 'Profil')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil de l\'utilisateur') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Carte de la photo de profil et informations personnelles -->
                <div class="md:col-span-1">
                    <div class="bg-white p-6 rounded-md shadow-md">
                        <img class="w-32 h-32 rounded-full object-cover mx-auto mb-4" src="{{ $user->profile_photo_url }}" alt="{{ $user->username }}">

                        <!-- Informations personnelles -->
                        <div class="text-left">
                            <h2 class="text-2xl font-semibold mb-2 text-indigo-700">Informations personnelles</h2>
                            <p class="text-gray-600"><strong>Prénom Nom :</strong> {{ $user->firstname }} {{ $user->lastname }}</p>
                            <p class="text-gray-600"><strong>Email :</strong> {{ $user->email }}</p>
                            <p class="text-gray-600"><strong>Classe :</strong> {{ $grade->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Carte de la description -->
                <div class="col-span-3 md:col-span-2">
                    <div class="bg-white p-6 rounded-md shadow-md h-full overflow-auto">
                        <h2 class="text-2xl font-semibold mb-4 text-indigo-700">Description</h2>
                        <p class="text-gray-600">{{ $user->description }}</p>
                    </div>
                </div>

                <!-- Carte des projets -->
                <div class="col-span-3 md:col-span-2">
                    <div class="bg-white p-6 rounded-md shadow-md">
                        <h2 class="text-2xl font-semibold mb-4 text-indigo-700">Projets</h2>
                        @if($user->allTeams()->isEmpty())
                            <p class="text-gray-600">Cet utilisateur n'est membre d'aucun projet.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($user->allTeams() as $index => $project)
                                    <div class="{{ $index > 1 ? 'md:col-span-1' : '' }} mb-4">
                                        <a href="{{ route('project.show', ['id' => $project->id]) }}">
                                            <h3 class="text-xl font-semibold text-blue-600 hover:underline">{{ $project->name }}</h3>
                                        </a>
                                        <p class="text-gray-500">
                                            @if ($user->teamRole($project)->key == 'owner')
                                                Propriétaire
                                            @else
                                                {{ Laravel\Jetstream\Jetstream::findRole($user->teamRole($project)->key)->name }}
                                            @endif
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
