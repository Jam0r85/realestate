<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		System Information
	@endcomponent

	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $invoice->invoiceGroup->branch->name }}
			@slot('title')
				Branch
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			<a href="{{ route('users.show', $invoice->owner->id) }}" title="{{ $invoice->owner->name }}">
				{{ $invoice->owner->name }}
			</a>
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