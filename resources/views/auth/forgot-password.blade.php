@section('title', 'Mot de passe oublié')
<x-app-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Vous avez oublié votre mot de passe ? Aucun souci. Indiquez simplement l\'adresse e-mail associée à votre compte, et nous vous enverrons un lien de réinitialisation du mot de passe.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Adresse Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button class="px-4 py-2 border bg-white border-black text-black rounded-md hover:bg-gray-400 focus:shadow-outline-green transition duration-300 ease-in-out">
                    {{ __('Réinitialiser mon mot de passe') }}
                </button>
            </div>
        </form>
    </x-authentication-card>
</x-app-layout>
