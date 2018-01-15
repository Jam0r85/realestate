@component('mail::message')
# Invoice Received

We acknowledge receipt of your <b>{{ money_formatted($expense->cost) }}</b> invoice {{ $expense->getData('contractor_reference') ? '(' . $expense->getData('contractor_reference') . ')' : '' }} for the property <b>{{ $expense->property->present()->fullAddress }}</b>.

@if ($expense->getBankAccount())
Payment will be made by Bank Transfer into the following account:-

<em>{{ $expense->contractor->getContractorBankAccount()->present()->inline }}</em>

Should the above account details be incorrect, please provide us with updated details as soon as possible.
@else
Payment will be made by Cheque and posted to you.
@endif

@include('email-templates.footer')

@endcomponent