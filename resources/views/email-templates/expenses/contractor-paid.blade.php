@component('mail::message')
# Invoice Payment

We have sent you <b>{{ $payment->present()->money('amount') }}</b> by {{ $payment->bank_account ? 'bank transfer' : 'cheque' }} for the invoice {{ $expense->getData('contractor_reference') ? '(' . $expense->getData('contractor_reference') . ')' : '' }} you sent us in relation to the work you carried out at <b>{{ $expense->property->present()->fullAddress }}</b>.

@if ($payment->bank_account)
Please allow 2 working days for payment to clear.
@endif

@include('email-templates.partials.footer')

@endcomponent