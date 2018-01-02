@component('mail::message')
# Invoice Received

We acknowledge receipt of your invoice {{ $expense->getData('contractor_reference') ? '(' . $expense->getData('contractor_reference') . ')' : '' }} for the property <b>{{ $expense->property->present()->fullAddress }}</b>.

Balance Due: {{ currency($expense->cost) }}

@include('email-templates.footer')

@endcomponent