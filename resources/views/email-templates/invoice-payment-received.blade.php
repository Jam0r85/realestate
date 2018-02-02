@component('mail::message')
# Thank You

We have received your payment of <b>{{ $payment->present()->money('amount') }}</b> for <b>{{ $invoice->present()->name }}</b>

@include('email-templates.partials.footer')

@endcomponent