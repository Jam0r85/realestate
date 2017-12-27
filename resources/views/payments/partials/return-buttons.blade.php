@if (model_from_plural($payment->parent_type) == 'Deposit')
	@component('partials.return-button')
		Deposit #{{ $payment->parent->id }}
		@slot('url')
			{{ route('deposits.show', [$payment->parent->id, 'payments']) }}
		@endslot
	@endcomponent
@endif

@if (model_from_plural($payment->parent_type) == 'Tenancy')
	@component('partials.return-button')
		Tenancy #{{ $payment->parent->id }}
		@slot('url')
			{{ route('tenancies.show', $payment->parent->id) }}
		@endslot
	@endcomponent
@endif

@if (model_from_plural($payment->parent_type) == 'Invoice')
	@component('partials.return-button')
		Invoice #{{ $payment->parent->id }}
		@slot('url')
			{{ route('invoices.show', $payment->parent->id) }}
		@endslot
	@endcomponent
@endif