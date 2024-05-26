<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Informations du profil') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Mettez à jour les informations de votre compte, votre adresse e-mail, votre description et votre année scolaire.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Photo de profil -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Champ pour le fichier de la photo de profil -->
                <input type="file" id="photo" class="hidden"
                       wire:model.live="photo"
                       x-ref="photo"
                       x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
                    " />

                <x-label for="photo" value="{{ __('Photo de profil') }}" />

                <!-- Photo de profil actuelle -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->username }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- Aperçu de la nouvelle photo de profil -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Sélectionner une nouvelle photo en format PNG') }}
                </x-secondary-button>

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Nom -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nom') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.username" required autocomplete="username" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- E-mail -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('E-mail') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            <!-- Vérification de l'e-mail -->
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Votre adresse e-mail n\'est pas vérifiée.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click.prevent="sendEmailVerification">
                        {{ __('Cliquez ici pour renvoyer le courriel de vérification.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('Un nouveau lien de vérification a été envoyé à votre adresse e-mail.') }}
                    </p>
                @endif
            @endif
        </div>

        <!-- Description -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="description" value="{{ __('Description') }}" />
            <x-textarea id="description" class="mt-1 block w-full" wire:model="state.description"></x-textarea>
            <x-input-error for="description" class="mt-2" />
        </div>

        <!-- Année scolaire -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="grade_id" value="{{ __('Quel année êtes-vous ?') }}" />
            <select wire:model="state.grade_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                @foreach(\App\Models\Grade::all() as $grade)
                    <option value="{{ $grade->id }}" {{ $grade->id == Auth::user()->grade_id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Enregistré.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Enregistrer') }}
        </x-button>
    </x-slot>
</x-form-section>
