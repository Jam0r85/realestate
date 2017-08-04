@component('mail::message')
# {{ $subject }}

{{ $body }}

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}
@endcomponent
