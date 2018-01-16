<div class="card mb-3">

	@component('partials.card-header')
		Invoice Items
	@endcomponent

	@include('invoice-items.partials.items-table', ['items' => $invoice->items])

</div>

<div class="card mb-3">

	@component('partials.card-header')
		Linked Users
	@endcomponent

	@include('users.partials.users-table', ['users' => $invoice->users])

</div>

<div class="card mb-3">

	@component('partials.card-header')
		Invoice Details
	@endcomponent

	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $invoice->invoiceGroup->name }}
			@slot('title')
				Invoice Group
			@endslot
		@endcomponent
	</ul>

</div>

<div class="card mb-3">

	@component('partials.card-header')
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
			<a href="{{ route('users.show', $invoice->owner->id) }}">
				{{ $invoice->owner->present()->fullName }}
			</a>
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $invoice->present()->dateCreated }}
			@slot('title')
				Created On
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $invoice->present()->dateUpdated }}
			@slot('title')
				Updated On
			@endslot
		@endcomponent
	</ul>
</div>