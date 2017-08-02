@component('mail::message')
# Hello!

Quick email to let you know that the latest rental statement for <b>{{ $this->statement->tenancy->property->name }}</b> has been posted to you today.

The balance of {{ currency($this->statement->landlord_balance_amount) }} was sent by {{ $this->statement->bank_account ? 'Bank Transfer' : 'Cheque' }}

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}

@component('mail::subcopy')
Should you have any questions regarding the rental statement when it arrives please contact us on 0121 355 0880.
@endcomponent

@endcomponent