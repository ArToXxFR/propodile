@section('title', 'Confirmer mon mot de passe')

<x-app-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Ceci est une zone sécurisée de l\'application. Veuillez confirmer votre mot de passe avant de continuer.') }}
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Mot de passe') }}</label>
                <input id="password" type="password" name="password" class="mt-1 p-2 w-full border rounded-md" required autocomplete="current-password" autofocus />
            </div>

            <div class="flex justify-end mt-4">
                <x-button>
                    {{ __('Confirmer') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-app-layout>
