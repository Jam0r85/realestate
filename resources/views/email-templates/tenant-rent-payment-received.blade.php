@component('mail::message')
# Rent Payment Received

We have received your rent payment of {{ currency($payment->amount) }}

Please find attached to this e-mail a receipt for your records.

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}
@endcomponent