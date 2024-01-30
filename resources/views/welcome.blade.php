@section('title', 'Page d\'accueil - Propodile')

<x-app-layout>
    <div class="relative min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
            <div class="fixed top-0 right-0 p-6 text-right z-10">
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

        <div class="flex flex-wrap p-6">
            @foreach ($projects as $project)
                <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
                    <a href="{{ route("project.show", ["id" => $project->id]) }}" class="block rounded border overflow-hidden hover:shadow-lg transition duration-300 ease-in-out">
                        <div class="p-4">
                            <h3 class="text-xl font-semibold text-indigo-600 mb-2 hover:text-indigo-800">{{ $project->title }}</h3>
                            <p class="text-gray-700 mb-2 h-20 overflow-hidden line-clamp-4">{{ $project->description }}</p>
                            <img src="{{ asset("storage/projects/images/" . basename($project->image)) }}" alt="" class="w-full h-auto rounded-lg mb-2">
                            <p class="text-gray-600 font-bold">Chef de projet: {{ $project->owner->username }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
