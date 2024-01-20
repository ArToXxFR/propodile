@component('mail::message')
{{ __(':user a demandé à rejoindre votre projet !', ['user' => $user]) }}

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
{{ __('If you do not have an account, you may create one by clicking the button below. After creating an account, you may click the invitation acceptance button in this email to accept the team invitation:') }}

@component('mail::button', ['url' => route('register')])
{{ __('Create Account') }}
@endcomponent

{{ __('If you already have an account, you may accept this invitation by clicking the button below:') }}

@else
{{ __('You may accept this invitation by clicking the button below:') }}
@endif


@component('mail::button', ['url' => $acceptUrl])
{{ __('Accepter la demande') }}
@endcomponent

@component('mail::button', ['url' => $acceptUrl])
    {{ __('Voir le profil') }}
@endcomponent

{{ __('If you did not expect to receive an invitation to this team, you may discard this email.') }}
@endcomponent
