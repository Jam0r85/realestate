{{-- Generic Footer --}}
Regards,<br />
{!! Auth::check() ? Auth::user()->present()->fullName . '<br />' : '' !!}
<b>{{ get_setting('company_name', config('app.name')) }}</b>