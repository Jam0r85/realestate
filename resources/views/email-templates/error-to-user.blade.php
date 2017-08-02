@component('mail::message')
# There was an error!

{{ $this->message }}

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}
@endcomponent
