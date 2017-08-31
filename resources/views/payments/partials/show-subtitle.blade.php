@if ($payment->parent_type == 'tenancies')
	<a href="{{ Route('tenancies.show', $payment->parent_id) }}">
		{{ $payment->parent->name }}
	</a>
@endif

@if ($payment->parent_type == 'invoices')
	<a href="{{ Route('invoices.show', $payment->parent_id) }}">
		Invoice #{{ $payment->parent->number }}
	</a>
@endif