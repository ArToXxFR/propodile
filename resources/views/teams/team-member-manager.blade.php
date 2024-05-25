<div>
    @if (Gate::check('addTeamMember', $team))
        <x-section-border />

        <!-- Add Team Member -->
        <div class="mt-6">
            <x-form-section submit="addTeamMember">
                <x-slot name="title">
                    {{ __('Ajouter un membre à l\'équipe') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Ajoutez un nouveau membre à votre équipe, lui permettant de collaborer avec vous.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-gray-600">
                            {{ __('Veuillez fournir l\'adresse e-mail de la personne que vous souhaitez ajouter à cette équipe.') }}
                        </div>
                    </div>

                    <!-- Member Email -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" type="email" class="mt-1 block w-full border rounded-md p-2" wire:model="addTeamMemberForm.email" />
                        <x-input-error for="email" class="mt-2" />
                    </div>

                    <!-- Role -->
                    @if (count($this->roles) > 0)
                        <div class="col-span-6 lg:col-span-4">
                            <x-label for="role" value="{{ __('Role') }}" />
                            <x-input-error for="role" class="mt-2" />

                            <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                                @foreach ($this->roles as $index => $role)
                                    <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 {{ $index > 0 ? 'border-t border-gray-200 focus:border-none rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                            wire:click="$set('addTeamMemberForm.role', '{{ $role->key }}')">
                                        <div class="{{ isset($addTeamMemberForm['role']) && $addTeamMemberForm['role'] !== $role->key ? 'opacity-50' : '' }}">
                                            <!-- Role Name -->
                                            <div class="flex items-center">
                                                <div class="text-sm text-gray-600 {{ $addTeamMemberForm['role'] == $role->key ? 'font-semibold' : '' }}">
                                                    {{ $role->name }}
                                                </div>

                                                @if ($addTeamMemberForm['role'] == $role->key)
                                                    <svg class="ms-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </div>

                                            <!-- Role Description -->
                                            <div class="mt-2 text-xs text-gray-600 text-start">
                                                {{ $role->description }}
                                            </div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </x-slot>

                <x-slot name="actions">
                    <x-action-message class="me-3 text-green-500" on="saved">
                        {{ __('Ajouté.') }}
                    </x-action-message>

                    <button class="inline-flex items-center px-4 py-2 border bg-white border-black text-black rounded-md hover:bg-gray-500 hover:text-black focus:outline-none focus:border-green-600 focus:shadow-outline-green active:bg-green-600 transition duration-300 ease-in-out">
                        Ajouter
                    </button>
                </x-slot>
            </x-form-section>
        </div>
    @endif

    @if ($team->teamInvitations->isNotEmpty() && Gate::check('addTeamMember', $team))
        <x-section-border />

        <!-- Team Member Invitations -->
        <div class="mt-6">
            <x-action-section>
                <x-slot name="title">
                    {{ __('Invitations en attente') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Ces personnes ont été invitées dans votre équipe et ont reçu un e-mail d\'invitation. Elles peuvent rejoindre l\'équipe en acceptant l\'invitation par e-mail.') }}
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($team->teamInvitations as $invitation)
                            <div class="flex items-center justify-between">
                                <div class="text-gray-600">{{ $invitation->email }}</div>

                                <div class="flex items-center">
                                    @if (Gate::check('removeTeamMember', $team))
                                        <!-- Cancel Team Invitation -->
                                        <button class="cursor-pointer ms-6 text-sm text-red-500 focus:outline-none"
                                                wire:click="cancelTeamInvitation({{ $invitation->id }})">
                                            {{ __('Annuler') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif

    @if ($team->users->isNotEmpty())
        <x-section-border />

        <!-- Manage Team Members -->
        <div class="mt-6">
            <x-action-section>
                <!-- Team Member List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($team->users->sortBy('name') as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="w-8 h-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->username }}">
                                    <div class="ms-4">{{ $user->username }}</div>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <!-- Manage Team Member Role -->
                                    @if (Gate::check('updateTeamMember', $team) && Laravel\Jetstream\Jetstream::hasRoles())
                                        <button
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-500 transition duration-300 transform hover:text-gray-700 focus:outline-none focus:underline {{ $currentRole == $role->key ? 'text-blue-500 underline' : '' }}"
                                            wire:click="manageRole('{{ $user->id }}')">
                                            {{ Laravel\Jetstream\Jetstream::findRole($user->teamRole($team)->key)->name }}
                                        </button>
                                    @elseif (Laravel\Jetstream\Jetstream::hasRoles())
                                        <div class="text-xs text-gray-400">
                                            {{ Laravel\Jetstream\Jetstream::findRole($user->teamRole($team)->key)->name }}
                                        </div>
                                    @endif

                                    <!-- Leave Team -->
                                    @if ($this->user->id === $user->id)
                                        <button
                                            class="px-4 py-2 border bg-white border-red-600 text-red-600 rounded-md hover:bg-red-100 hover:text-red-600 focus:outline-none focus:border-green-600 focus:shadow-outline-green active:bg-green-600 transition duration-300 ease-in-out"
                                            wire:click="$toggle('confirmingLeavingTeam')">
                                            {{ __('Quitter') }}
                                        </button>
                                    @elseif (Gate::check('removeTeamMember', $team))
                                        <!-- Remove Team Member -->
                                        <button
                                            class="px-4 py-2 border bg-white border-red-600 text-red-600 rounded-md hover:bg-red-100 hover:text-red-600 focus:outline-none focus:border-green-600 focus:shadow-outline-green active:bg-green-600 transition duration-300 ease-in-out"
                                            wire:click="confirmTeamMemberRemoval('{{ $user->id }}')">
                                            {{ __('Éjecter') }}
                                        </button>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif

    <!-- Role Management Modal -->
    <x-dialog-modal wire:model.live="currentlyManagingRole">
        <x-slot name="title">
            {{ __('Gérer le rôle') }}
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-1 gap-4">
                @foreach ($this->roles as $index => $role)
                    <button
                        type="button"
                        class="inline-flex items-center w-full px-4 py-2 border border-blue-500 rounded-md text-blue-500 bg-white hover:bg-blue-100 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 {{ $currentRole == $role->key ? 'border-blue-500' : '' }}"
                        wire:click="$set('currentRole', '{{ $role->key }}')"
                    >
                        <span class="text-sm font-medium">{{ $role->name }}</span>
                        @if ($currentRole == $role->key)
                            <svg class="ml-2 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @endif
                    </button>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="stopManagingRole" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>

            <button class="ms-3" wire:click="updateRole" wire:loading.attr="disabled">
                {{ __('Enregistrer') }}
            </button>
        </x-slot>
    </x-dialog-modal>


    <!-- Leave Team Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingLeavingTeam">
        <x-slot name="title">
            {{ __('Quitter l\'équipe') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Êtes-vous sûr de vouloir quitter cette équipe ?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingLeavingTeam')" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="leaveTeam" wire:loading.attr="disabled">
                {{ __('Quitter') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <!-- Remove Team Member Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingTeamMemberRemoval">
        <x-slot name="title">
            {{ __('Supprimer le membre de l\'équipe') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Êtes-vous sûr de vouloir supprimer cette personne de l\'équipe ?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="removeTeamMember" wire:loading.attr="disabled">
                {{ __('Supprimer') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
