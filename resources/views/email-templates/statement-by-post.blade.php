@component('mail::message')
# Rental Statement

We have processed the rental statement for <b>{{ $statement->property()->present()->fullAddress }}</b>.

The statement has been posted to you.

@component('mail::panel')
Would you prefer to have the renal statement attached to this e-mail? Let us know by simply replying to this e-mail.
@endcomponent

@include('email-templates.partials.footer')

@endcomponent