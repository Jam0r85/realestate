@component('mail::message')
# Hello!

Please find attached the latest rental statement for the property <b>{{ $statement->tenancy->property->name }}</b> which was processed today.

The amount of {{ currency($statement->landlord_balance_amount) }} was sent to you by {{ $statement->bank_account ? 'Bank Transfer' : 'Cheque' }}.

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}

@component('mail::subcopy')
Please note that this is an automatic e-mail and should you have any questions regarding this e-mail or the attached rental statement please you should contact us on 0121 355 0880.
@endcomponent

@endcomponent