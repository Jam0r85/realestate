@component('mail::message')
# Invoice Payment

We have sent you {{ currency($payment->amount) }} by {{ $payment->bank_account ? 'bank transfer' : 'cheque' }}.

@if ($expense->getData('contractor_reference'))
Your invoice reference is {{ $expense->getData('contractor_reference') }}
@endif

It relates to the work you carried out at the property - <b>{{ $expense->property->present()->fullAddress }}</b>

@if ($expense->balance <= 0)
Your invoice has been paid in full.
@else
Your invoice total was {{ currency($expense->cost) }}.

The remaining balance is {{ currency($expense->balance) }}.
@endif

Thanks,<br />
{{ get_setting('company_name', config('app.name')) }}
@endcomponent