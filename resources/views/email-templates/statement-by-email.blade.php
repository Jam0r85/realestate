@component('mail::message')
# Rental Statement

Please find attached the {{ $statement->sent_at ? '' : 'new' }} rental statement for <b>{{ $statement->property()->present()->fullAddress }}</b>.

@include('email-templates.partials.footer')

@endcomponent