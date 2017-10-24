@component('mail::message')
# Gas Inspection

{!! $body !!}

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}
@endcomponent
