@component('mail::message')
# {{ $subject }}

{{ $message }}

Thanks,<br />
{!! Auth::check() ? Auth::user()->present()->fullName . '<br />' : '' !!}
{{ get_setting('company_name', config('app.name')) }}
@endcomponent