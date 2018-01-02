@component('mail::message')
# {{ $subject }}

{{ $message }}

@include('email-templates.footer')

@endcomponent