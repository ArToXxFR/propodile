@component('mail::message')
    # {{ __('Demande de rejoindre votre projet') }}

    {{ __(':user a demandé à rejoindre votre projet !', ['user' => $user]) }}

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
        {{ __('Si vous n\'avez pas de compte, vous pouvez en créer un en cliquant sur le bouton ci-dessous. Après avoir créé un compte, vous pourrez cliquer sur le bouton d\'acceptation de l\'invitation dans cet email pour accepter la demande :') }}

        @component('mail::button', ['url' => route('register')])
            {{ __('Créer un compte') }}
        @endcomponent
    @endif

    {{ __('Si vous avez déjà un compte, vous pouvez accepter cette demande en cliquant sur le bouton ci-dessous :') }}

    @component('mail::button', ['url' => $acceptUrl])
        {{ __('Accepter la demande') }}
    @endcomponent

    @component('mail::button', ['url' => $profileUrl])
        {{ __('Voir le profil') }}
    @endcomponent

    {{ __('Si vous n\'attendiez pas de recevoir une demande pour rejoindre ce projet, vous pouvez ignorer cet email.') }}
@endcomponent
