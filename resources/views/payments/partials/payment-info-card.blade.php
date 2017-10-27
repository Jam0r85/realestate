<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-gbp"></i> Payment Information
	</div>
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ currency($payment->amount) }}
			@slot('title')
				Amount
			@endslot
		@endcomponent

		@component('partials.bootstrap.list-group-item')
			{{ $payment->method->name }}
			@slot('title')
				Payment Method
			@endslot
		@endcomponent

		@if ($payment->parent_type == 'invoices')

			@component('partials.bootstrap.list-group-item')
				<a href="{{ route('invoices.show', $payment->parent->id) }}" title="{{ $payment->parent->name }}">
					{{ $payment->parent->name }}
				</a>
				@slot('title')
					Invoice
				@endslot
			@endcomponent

			@if ($payment->parent->property)

				@component('partials.bootstrap.list-group-item')
					<a href="{{ route('properties.show', $payment->parent->property->id) }}" title="{{ $payment->parent->property->short_name }}">
						{{ $payment->parent->property->short_name }}
					</a>
					@slot('title')
						Property
					@endslot
				@endcomponent

			@endif

		@elseif ($payment->parent_type == 'tenancies')

			@component('partials.bootstrap.list-group-item')
				<a href="{{ route('tenancies.show', $payment->parent->id) }}" title="{{ $payment->parent->name }}">
					{{ $payment->parent->name }}
				</a>
				@slot('title')
					Tenancy
				@endslot
			@endcomponent

			@component('partials.bootstrap.list-group-item')
				<a href="{{ route('properties.show', $payment->parent->property->id) }}" title="{{ $payment->parent->property->short_name }}">
					{{ $payment->parent->property->short_name }}
				</a>
				@slot('title')
					Property
				@endslot
			@endcomponent

		@endif

	</ul>
</div>