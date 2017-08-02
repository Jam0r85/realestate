@component('mail::message')
# Error Sending Statement {{ $statement->id }}

{{ $message }}

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}
@endcomponent
