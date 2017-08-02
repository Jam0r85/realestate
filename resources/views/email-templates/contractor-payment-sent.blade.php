@component('mail::message')
# New payment

We have set you new, details of which are as follows:-

@foreach ($this->payments as $payment)

@component('mail::panel')
## Hello
£400
@endcomponent

@endforeach

The payment was sent by bank transfer and should arrive in your account in about 3 working days.

Thanks,<br>
{{ get_setting('company_name', config('app.name')) }}
@endcomponent
