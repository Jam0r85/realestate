@component('mail::message')
# Invoice Payment

We have sent you {{ currency($payment->amount) }}

@if ($expense->getData('contractor_reference'))
Your invoice reference is {{ $expense->getData('contractor_reference') }}
@endif

It relates to the work you carried out at the property -<br />
<b>{{ $expense->property->present()->fullAddress }}</b>

@if ($payment->bank_account)
Payment was sent to you by Bank Transfer and normally takes 3 working days.
@else
Payment has been sent by Cheque and is in the post.
@endif

@if ($expense->balance <= 0)
Your invoice {{ currency($expense->cost) }} has been paid in full.
@else
Your invoice total was {{ currency($expense->cost) }}.

The remaining balance is {{ currency($expense->balance) }}.
@endif

Thanks,<br />
{{ get_setting('company_name', config('app.name')) }}
@endcomponent