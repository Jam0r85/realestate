@component('mail::message')
# Hello!

Quick email to let you know that the latest rental statement for <b>{{ $statement->tenancy->property->name }}</b> has been posted to you today.

The amount of {{ currency($statement->landlord_balance_amount) }} was sent to you by {{ $statement->bank_account ? 'Bank Transfer' : 'Cheque' }}.

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}

@component('mail::subcopy')
Please note that this is an automatic e-mail and should you have any questions regarding this e-mail or your rental statement when it arrives you should contact us on 0121 355 0880.
@endcomponent

@endcomponent