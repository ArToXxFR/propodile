@section('title', 'Tableau de bord - Admin')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex space-x-8">
                <!-- Projets -->
                <div class="w-1/2">
                    <x-dashboard-section title="Projets">
                        @foreach ($projects as $project)
                            <div class="mb-4">
                                <a href="{{ route('project.show', ['id' => $project->id]) }}">
                                    <x-dashboard-item :name="$project->title" :link="route('project.show', ['id', $project->id])" />
                                </a>
                            </div>
                        @endforeach
                        <div class="mt-4">
                            <a href="{{ route('admin.projects') }}">
                                <x-button class="w-full">
                                    {{ __('Voir plus de projets...') }}
                                </x-button>
                            </a>
                        </div>
                    </x-dashboard-section>
                </div>

                <!-- Utilisateurs -->
                <div class="w-1/2">
                    <x-dashboard-section title="Utilisateurs" :items="$users" route="user.show">
                        @foreach($users as $user)
                            <a href="{{ route('user.show', ['username' => $user->username]) }}">
                                <div class="mb-4">
                                    <x-dashboard-item :name="$user->username" />
                                </div>
                            </a>
                        @endforeach
                        <div class="mt-4">
                            <a href="{{ route('admin.users') }}">
                                <x-button class="w-full">
                                    {{ __('Voir plus d\'utilisateurs...') }}
                                </x-button>
                            </a>
                        </div>
                        <!-- Bouton pour voir les utilisateurs bannis -->
                        <div class="mt-4">
                            <a href="{{ route('admin.users.banned') }}">
                                <x-button class="w-full">
                                    {{ __('Voir les utilisateurs bannis') }}
                                </x-button>
                            </a>
                        </div>
                    </x-dashboard-section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
