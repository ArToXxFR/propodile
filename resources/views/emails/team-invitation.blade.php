@component('mail::message')
    {{ __('Invitation dans une équipe - Propodile') }}

    {{ __('Vous avez été invité à rejoindre l\'équipe :team !', ['team' => $invitation->team->name]) }}

    {{ __("Si vous n'avez pas de compte, vous pouvez en créer un en cliquant sur le bouton ci-dessous. Après avoir créé un compte, vous pourrez cliquer sur le bouton d'acceptation de l'invitation dans cet email pour accepter l'invitation dans l'équipe :") }}

    @component('mail::button', ['url' => route('register')])
        {{ __('Créer un compte') }}
    @endcomponent

    {{ __('Si vous avez déjà un compte, vous pouvez accepter cette invitation en cliquant sur le bouton ci-dessous :') }}

    @component('mail::button', ['url' => $acceptUrl])
        {{ __('Accepter l\'invitation') }}
    @endcomponent

    {{ __('Si vous n\'attendiez pas de recevoir une invitation pour rejoindre cette équipe, vous pouvez ignorer cet email.') }}
@endcomponent
