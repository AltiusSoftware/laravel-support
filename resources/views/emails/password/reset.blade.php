@component('mail::message')
# Hello!

Click below to reset your password

@component('mail::button', ['url' => $url])
Reset
@endcomponent

This link will expire {{ $expire }}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
