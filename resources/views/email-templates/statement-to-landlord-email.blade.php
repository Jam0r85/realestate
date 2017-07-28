@component('mail::message')
# New Rental Statement

Please find attached your new rental statement for the property <b>{{ $statement->tenancy->property->name }}</b>.

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}

@component('mail::subcopy')
Should you have any questions regarding this rental statement please feel free to contact us on 0121 355 0880.
@endcomponent
@endcomponent