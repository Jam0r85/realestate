<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-cogs"></i> System Information
	</div>
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $invoice->invoiceGroup->branch->name }}
			@slot('title')
				Branch
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			@if ($invoice->owner)
				<a href="{{ route('users.show', $invoice->owner->id) }}" title="{{ $invoice->owner->name }}">
					{{ $invoice->owner->name }}
				</a>
			@endif
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($invoice->created_at) }}
			@slot('title')
				Created On
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($invoice->updated_at) }}
			@slot('title')
				Updated On
			@endslot
		@endcomponent
	</ul>
</div>