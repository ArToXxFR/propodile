@section('title', 'Tableau de bord')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                    <h3 class="text-2xl font-semibold mb-4 sm:mb-0">Mes Projets</h3>
                    <a href="{{ route('project.create.form') }}" class="inline-flex items-center px-4 py-2 border border-pink-500 text-pink-500 rounded-md hover:bg-pink-100 hover:text-pink-700 focus:outline-none focus:border-blue-600 focus:shadow-outline-blue active:bg-blue-600 transition duration-300 ease-in-out">Créer un nouveau projet</a>
                </div>
                <ul class="divide-y divide-gray-200">
                    @forelse($teams as $team)
                        <li class="py-4 sm:flex justify-between items-center">
                            <div class="mb-2 sm:mb-0">
                                <p class="text-xl font-semibold">{{ $team->name }}</p>
                                <p class="text-gray-500">
                                    @if ($user->teamRole($team)->key == 'owner')
                                        Propriétaire
                                    @else
                                        {{ Laravel\Jetstream\Jetstream::findRole($user->teamRole($team)->key)->name }}
                                    @endif
                                </p>
                            </div>
                            <div class="flex space-x-2 sm:space-x-4">
                                <a href="{{ route('project.show', ['id' => $team->project_id]) }}" class="inline-flex items-center px-4 py-2 border border-blue-500 text-blue-500 rounded-md hover:bg-blue-100 hover:text-blue-700 focus:outline-none focus:border-blue-600 focus:shadow-outline-blue active:bg-blue-600 transition duration-300 ease-in-out">Voir le Projet</a>
                                <a href="{{ route('teams.show', ['team' => $team->id]) }}" class="inline-flex items-center px-4 py-2 border border-yellow-600 text-yellow-600 rounded-md hover:bg-yellow-100 hover:text-yellow-700 focus:outline-none focus:border-green-600 focus:shadow-outline-green active:bg-green-600 transition duration-300 ease-in-out">Voir l'Équipe</a>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 text-gray-500">Aucun projet trouvé.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
