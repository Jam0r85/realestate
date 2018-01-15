@component('mail::message')
# Rent Payment Received

We have received your rent payment of {{ money_formatted($payment->amount) }}

Please find attached to this e-mail a receipt for your records.

@include('email-templates.footer')

@endcomponent