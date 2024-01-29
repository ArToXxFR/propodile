@section('title', 'Page d\'accueil - Propodile')
<x-app-layout>
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-red-500 selection:text-white">
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
        <div class="flex flex-wrap w-screen">
            @foreach ($projects as $project)
                <div class="w-1/3 p-4 px-8">
                    <a href="{{ route("project.show", ["id" => $project->id]) }}" class="text-xl font-semibold text-indigo-600 mb-2 hover:text-indigo-800">
                        <div class="flex flex-col h-full mx-auto border rounded">
                            {{ $project->title }}
                            <p class="text-gray-700 flex-grow">
                                {{ $project->description }}
                            </p>
                            <img src="{{ asset("storage/projects/images/" . basename($project->image)) }}" alt="">
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

