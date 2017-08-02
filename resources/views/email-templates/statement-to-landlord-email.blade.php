@component('mail::message')
# Hello!

Please find attached the latest rental statement for the property <b>{{ $this->statement->tenancy->property->name }}</b> which was processed today.

The balance of {{ currency($this->statement->landlord_balance_amount) }} was sent by {{ $this->statement->bank_account ? 'Bank Transfer' : 'Cheque' }}

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}

@component('mail::subcopy')
Should you have any questions regarding this rental statement please contact us on 0121 355 0880.
@endcomponent

@endcomponent