@section('title', 'Projets - Admin')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des Projets') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                @foreach ($projects as $project)
                    <div class="bg-white p-6 rounded-md shadow-md flex items-center mb-4">
                        <div class="flex-grow">
                            <h3 class="text-lg font-semibold">{{ $project->title }}</h3>
                            <p class="text-gray-600">
                                Propriétaire: {{ $project->owner->username }}
                            </p>
                            <p class="text-gray-600">
                                Membres: {{ $project->team->allUsers()->count() }}
                            </p>
                        </div>
                        <a href="{{ route('project.show', ['id' => $project->id]) }}" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-700">
                            Voir le projet
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
