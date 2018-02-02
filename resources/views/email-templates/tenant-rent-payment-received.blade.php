@component('mail::message')
# Thank You

We have received your rent payment of <b>{{ $payment->present()->money('amount') }}</b>.

@include('email-templates.partials.footer')

@endcomponent