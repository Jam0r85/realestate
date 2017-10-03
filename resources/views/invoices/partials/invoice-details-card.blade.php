<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-info-circle"></i> Invoice Information
	</div>
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
	</ul>
</div>