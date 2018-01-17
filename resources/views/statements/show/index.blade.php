<div class="card mb-3">
	@component('partials.card-header')
		Statement Details
	@endcomponent
	<ul class="list-group list-group-flush">
		@component('partials.list-group-item')
			{{ $statement->present()->money('amount') }}
			@slot('title')
				Amount
			@endslot
		@endcomponent
		@component('partials.list-group-item')
			{{ $statement->present()->money('invoices_net_total') }}
			@slot('title')
				Invoices Net
			@endslot
		@endcomponent
		@component('partials.list-group-item')
			{{ $statement->present()->money('invoices_tax_total') }}
			@slot('title')
				Invoices Tax
			@endslot
		@endcomponent
		@component('partials.list-group-item')
			{{ $statement->present()->money('expenses_total') }}
			@slot('title')
				Expenses Total
			@endslot
		@endcomponent
		@component('partials.list-group-item')
			{{ $statement->present()->money('total_cost') }}
			@slot('title')
				Total Cost
			@endslot
		@endcomponent
		@component('partials.list-group-item')
			{{ $statement->present()->money('landlord_payment') }}
			@slot('title')
				Landlord Payment
			@endslot
		@endcomponent
		@component('partials.list-group-item')
			{{ $statement->present()->money('total_paid') }}
			@slot('title')
				Total Paid
			@endslot
		@endcomponent
		@component('partials.list-group-item')
			<a href="{{ route('tenancies.show', $statement->tenancy_id) }}">
				{{ $statement->tenancy->present()->name }}
			</a>
			@slot('title')
				Tenancy
			@endslot
		@endcomponent
		@component('partials.list-group-item')
			<a href="{{ route('properties.show', $statement->tenancy->property_id) }}">
				{{ $statement->tenancy->property->present()->fullAddress }}
			</a>
			@slot('title')
				Property
			@endslot
		@endcomponent
	</ul>
</div>

<div class="card mb-3">
	@component('partials.card-header')
		System Information
	@endcomponent
	<ul class="list-group list-group-flush">
		@component('partials.list-group-item')
			{{ $statement->owner->present()->fullName }}
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.list-group-item')
			{{ date_formatted($statement->created_at) }}
			@slot('title')
				Created
			@endslot
		@endcomponent
		@component('partials.list-group-item')
			{{ datetime_formatted($statement->updated_at) }}
			@slot('title')
				Last Updated
			@endslot
		@endcomponent
	</ul>
</div>