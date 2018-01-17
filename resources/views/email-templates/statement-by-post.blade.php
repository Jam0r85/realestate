@component('mail::message')
# Your Rental Statement

Quick email to let you know that the latest rental statement for <b>{{ $statement->property()->present()->fullAddress }}</b> has been posted to you today.

The amount of {{ $statement->present()->money('landlord_payment') }} was sent to you by {{ $statement->bank_account ? 'Bank Transfer' : 'Cheque' }}.

@include('email-templates.footer')

@component('mail::subcopy')
Please note that this is an automatic e-mail and should you have any questions regarding this e-mail or your rental statement when it arrives you should contact us on 0121 355 0880.
@endcomponent

@endcomponent