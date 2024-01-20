<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @foreach($teams as $team)
                    <div>
                        {{ $team->name }}
                        @if ($user->teamRole($team)->key == 'owner')
                            Propriétaire
                        @else
                            {{ Laravel\Jetstream\Jetstream::findRole($user->teamRole($team)->key)->name }}
                        @endif

                        <a href="{{ route('project.show', ['id' => $team->project_id]) }}">Projet</a>
                        <a href="{{ route('teams.show', ['team' => $team->id]) }}">Equipe</a>
                    </div>  
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
