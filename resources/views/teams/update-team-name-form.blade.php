<x-form-section submit="updateTeamName">
    <x-slot name="form">
        <!-- Informations sur le propriétaire de l'équipe -->
        <div class="col-span-6">
            <x-label value="{{ __('Propriétaire') }}" class="text-lg font-semibold mb-2" />

            <div class="flex items-center mt-2 space-x-4">
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $team->owner->profile_photo_url }}" alt="{{ $team->owner->username }}">
                <div>
                    <div class="text-gray-900 text-xl font-semibold">{{ $team->owner->username }}</div>
                    <div class="text-gray-700 text-sm">{{ $team->owner->email }}</div>
                </div>
            </div>
        </div>

        <!-- Nom de l'équipe -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nom du projet') }}" class="text-lg font-semibold mb-2" />

            <x-input id="name"
                     type="text"
                     class="mt-1 block w-full border rounded-md p-2"
                     wire:model="state.name"
                     :disabled="! Gate::check('update', $team)" />

            <x-input-error for="name" class="mt-2" />
        </div>
    </x-slot>

    @if (Gate::check('update', $team))
        <x-slot name="actions">
            <x-action-message class="me-3 text-green-500" on="saved">
                {{ __('Enregistré.') }}
            </x-action-message>

            <button class="inline-flex items-center px-4 py-2 border bg-white border-black text-black rounded-md hover:bg-gray-500 hover:text-black focus:outline-none focus:border-green-600 focus:shadow-outline-green active:bg-green-600 transition duration-300 ease-in-out">
                {{ __('Enregistrer') }}
            </button>
        </x-slot>
    @endif
</x-form-section>
