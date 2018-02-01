@component('mail::message')
# Invoice Received

We have received your invoice {{ $expense->getData('contractor_reference') ? '(' . $expense->getData('contractor_reference') . ')' : '' }} for the amount <b>{{ $expense->present()->money('cost') }}</b> in relation to the work you carried out at <b>{{ $expense->property->present()->fullAddress }}</b>.

@if ($expense->getBankAccount())
Payment will be made by Bank Transfer into the following account:-

<em>{{ $expense->contractor->getContractorBankAccount()->present()->inline }}</em>

Should the above account details be incorrect, please provide us with updated details as soon as possible.
@else
Payment will be made by Cheque and posted to you.
@endif

@include('email-templates.partials.footer')

@endcomponent