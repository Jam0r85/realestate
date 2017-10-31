<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Invoice Information
	@endcomponent
	
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $invoice->number }}
			@slot('title')
				Number
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			<a href="{{ route('invoice-groups.show', $invoice->invoiceGroup->id) }}" title="{{ $invoice->invoiceGroup->name }}">
				{{ $invoice->invoiceGroup->name }}
			</a>
			@slot('title')
				Invoice Group
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			@if ($invoice->property)
				<a href="{{ route('properties.show', $invoice->property_id) }}" title="{{ $invoice->property->name }}">
					{{ $invoice->property->name }}
				</a>
			@else
				-
			@endif
			@slot('title')
				Property
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')

			@if ($invoice->recurring)
				Every {{ $invoice->recurring->interval }}  {{ $invoice->recurring->interval_type }}
				<small class="text-muted d-block">
					Next invoice <b>{{ date_formatted($invoice->recurring->next_invoice) }}</b>
				</small>
			@elseif ($invoice->recur)
				<a href="{{ route('invoices.show', $invoice->recur->invoice->id) }}" class="d-block">
					Created from Invoice {{ $invoice->recur->invoice->name }}
				</a>
				Every {{ $invoice->recur->interval }}  {{ $invoice->recur->interval_type }}
				<small class="text-muted d-block">
					Next invoice <b>{{ date_formatted($invoice->recur->next_invoice) }}</b>
				</small>
			@else
				Never
			@endif

			@slot('title')
				Recurring
			@endslot
		@endcomponent
	</ul>
</div>