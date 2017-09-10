@component('mail::message')
# Rent payment received

We have received your rent payment of {{ currency($payment->amount) }}

Please find attached to this e-mail a rent receipt for your records.

@if ($payment->note)
{{ $payment->note }}
@endif

Thanks,<br>
{{ get_setting('company_name') }}
@endcomponent
