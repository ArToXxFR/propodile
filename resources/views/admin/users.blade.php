<!-- resources/views/livewire/user-list.blade.php -->

<div>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Liste des utilisateurs') }}
            </h2>
        </x-slot>

        <div class="py-6 sm:py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="space-y-4">
                    @foreach ($users as $user)
                        <div class="flex flex-col sm:flex-row items-center justify-between border-b border-gray-200 p-4">
                            <div class="flex items-center mb-4 sm:mb-0">
                                <img class="w-8 h-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->username }}">
                                <div class="ml-2">
                                    <div class="text-sm font-medium text-gray-800">{{ $user->firstname }} {{ $user->lastname }}</div>
                                    <div class="text-sm text-gray-600">{{ Laravel\Jetstream\Jetstream::findRole($user->role)->name }}</div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <a href="{{ route('user.show', ['username' => $user->username]) }}" class="px-4 py-2 border bg-white border-blue-500 text-blue-500 rounded-md hover:bg-blue-100 hover:text-blue-500 focus:shadow-outline-green transition duration-300 ease-in-out">Voir le profil</a>
                                <a href="#" class="px-4 py-2 border bg-white border-red-500 text-red-500 rounded-md hover:bg-red-100 hover:text-red-500 focus:shadow-outline-green transition duration-300 ease-in-out">Bannir</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Affichage de la pagination -->
                {{ $users->links() }}
            </div>
        </div>
    </x-app-layout>
</div>
