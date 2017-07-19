@component('mail::message')
# {{ $subject }}

{{ $body }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
