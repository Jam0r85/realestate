@component('mail::message')
# Your Rental Statement

Please find attached the rental statement for the property <b>{{ $statement->property()->present()->fullAddress }}</b> {{ !$statement->sent_at ? ' which was prosessed today' : '' }}.

@if (!$statement->sent_at)
The amount of {{ $statement->present()->money('landlord_payment') }} was sent to you by {{ $statement->bank_account ? 'Bank Transfer' : 'Cheque' }}.
@endif

@include('email-templates.footer')

@if (!$statement->sent_at)
@component('mail::subcopy')
Please note that this is an automatic e-mail and should you have any questions regarding this e-mail or the attached rental statement please you should contact us on 0121 355 0880.
@endcomponent
@endif

@endcomponent