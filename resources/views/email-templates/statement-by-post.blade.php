@component('mail::message')
# Rental Statement

We have processed the new rental statement for <b>{{ $statement->property()->present()->fullAddress }}</b>.

The statement has been posted to you.

@include('email-templates.partials.footer')

@endcomponent