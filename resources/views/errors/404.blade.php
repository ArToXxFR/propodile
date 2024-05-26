<!-- resources/views/404.blade.php -->
<x-app-layout>
    <div class="flex items-center flex-col justify-center h-screen bg-gray-100">
        <a href="{{ route('home') }}">
            <img class="max-h-24 rounded mb-8" src="{{ asset('storage/app-logo.png') }}" alt="Propodile">
        </a>
        <div class="text-center">
            <div class='uppercase text-4xl text-red-500 font-bold mb-4'>
                Erreur 404
            </div>
            <p class="text-gray-800">
                Oups! Il semble que vous ayez dévié du chemin. Notre sympathique Propodile adore dévorer des pages, mais il n'était pas prêt pour celle-ci.
            </p>
            <p class="text-gray-800">
                Revenez à des eaux plus sûres en utilisant la navigation.
            </p>
        </div>
    </div>
</x-app-layout>
