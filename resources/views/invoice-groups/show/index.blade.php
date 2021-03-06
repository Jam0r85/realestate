@component('partials.card')
	@slot('header')
		Finances
	@endslot
	@component('partials.bootstrap.list-group-item')
		{{ count($group->invoices) }}
		@slot('title')
			All Invoices
		@endslot
	@endcomponent
	@component('partials.bootstrap.list-group-item')
		{{ $group->getPaidInvoicesCount() }}
		@slot('title')
			Paid Invoices
		@endslot
	@endcomponent
	@component('partials.bootstrap.list-group-item')
		{{ $group->getUnpaidInvoicesCount() }}
		@slot('title')
			Unpaid Invoices
		@endslot
	@endcomponent
@endcomponent

@component('partials.card')
	@slot('header')
		System Information
	@endslot
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $group->branch->name }}
			@slot('title')
				Registered Branch
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($group->created_at) }}
			@slot('title')
				Registered
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ datetime_formatted($group->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
	</ul>
@endcomponent