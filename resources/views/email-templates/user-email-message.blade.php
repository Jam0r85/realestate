@component('mail::message')
# {{ $subject }}

{{ $message }}

{{ Auth::check() ? Auth::user()->name : 'Thanks' }},<br>
{{ get_setting('company_name', config('app.name')) }}
@endcomponent