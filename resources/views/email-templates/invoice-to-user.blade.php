@component('mail::message')
# Your Invoice

Please find attached your invoice.

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}

@endcomponent