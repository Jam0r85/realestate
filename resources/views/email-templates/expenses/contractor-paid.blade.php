@component('mail::message')
# Invoice Payment

We have sent you {{ money_formatted($payment->amount) }} by {{ $payment->bank_account ? 'bank transfer' : 'cheque' }}.

@if ($expense->getData('contractor_reference'))
Your invoice reference is {{ $expense->getData('contractor_reference') }}
@endif

It relates to the work you carried out at the property - <b>{{ $expense->property->present()->fullAddress }}</b>

@if (count($expense->documents))
We have attached your {{ str_plural('invoice', count($expense->documents)) }} to this email.
@endif

@if ($expense->balance <= 0)
Your invoice has now been paid in full.
@else
Your invoice total was {{ money_formatted($expense->cost) }}.

The remaining balance is {{ money_formatted($expense->balance) }}.
@endif

@include('email-templates.footer')

@endcomponent