@component('mail::message')
# Your New Rental Statement

Please find attached to this email your latest rental statement and invoice for the property below:

<b>{{ $statement->tenancy->property->name }}</b>

Thanks,<br>
{{ setting('company_name', config('app.name')) }}

@component('mail::subcopy')
Should you have any questions regarding this rental statement or invoice please contact us on 0121 355 0880.
@endcomponent
@endcomponent