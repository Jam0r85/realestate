@component('mail::message')
# Hello!

You now have an account with Steve Morris &amp; Son.

If you didn't register yourself then this account was created on your behalf by us as you are either a tenant, landlord or vendor who is using or has used our services previously.

Don't worry, this account is purely for our internal systems and none of your details are passed to any third parties.

Your account password is:

@component('mail::panel')
{{ $password }}
@endcomponent

You can use this along with your email to sign into your account online.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
