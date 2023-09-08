<x-mail::message>
# {{ __('New Chirp from :username', ['username' => $chirp->user->name]) }}

{{ str($chirp->message)->limit(50) }}

<x-mail::button :url="$url">
{{ __('Go to Chirper') }}
</x-mail::button>

{{ __('Thank you for using our application!') }},<br>
{{ config('app.name') }}
</x-mail::message>
