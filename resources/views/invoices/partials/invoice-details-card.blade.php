<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-cogs"></i> Invoice Information
	</div>
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			<a href="{{ route('properties.show', $invoice->property_id) }}" title="{{ $invoice->property->name }}">
				{{ $invoice->property->name }}
			</a>
			@slot('title')
				Property
			@endslot
		@endcomponent
	</ul>
</div>