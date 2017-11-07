@component('mail::message')
# Your Rental Statement

Please find attached the rental statement for the property <b>{{ $statement->tenancy->property->name }}</b>.

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}

@endcomponent