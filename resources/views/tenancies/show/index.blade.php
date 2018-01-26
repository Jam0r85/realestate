{{-- Quick glance Rent and Deposit balance cards --}}
<div class="row mb-3">
	<div class="col-12 col-lg-4">

		@include('tenancies.partials.rent-card')

	</div>
	<div class="col-12 col-lg-4">

		@include('tenancies.partials.deposit-card')

	</div>
</div>

{{-- Tenants Table --}}
@component('partials.card')
	@slot('header')
		Tenant(s)
	@endslot
	@include('users.partials.users-table', ['users' => $tenancy->users])
@endcomponent

{{-- Landlords Table --}}
@component('partials.card')
	@slot('header')
		Landlord(s)
	@endslot
	@include('users.partials.users-table', ['users' => $tenancy->property->owners])
@endcomponent

{{-- Tenancy Details --}}
@component('partials.card')
	@slot('header')
		Tenancy Details
	@endslot
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->service->name }} ({{ $tenancy->service->present()->monthlyChargeFormatted }})
			@slot('title')
				Service
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->present()->rentAmount }}
			@slot('title')
				Current Rent
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->present()->monthlyServiceChargeWithoutTax }} ({{ $tenancy->present()->monthlyServiceChargeWithTax }})
			@slot('title')
				Monthly Service Charge
			@endslot
		@endcomponent
		@if (count($tenancy->discounts))
			@component('partials.bootstrap.list-group-item')
				<ul>
					@foreach ($tenancy->discounts as $discount)
						<li>
							{{ $discount->name }} - {{ $discount->present()->amount }}
						</li>
					@endforeach
				@slot('title')
					Discounts
				@endslot
			@endcomponent
		@endif
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->present()->startDate }}
			@slot('title')
				Started
			@endslot
		@endcomponent
	</ul>
@endcomponent

<div class="card mb-3">
	@component('partials.card-header')
		System Information
	@endcomponent

	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->property->branch->name }}
			@slot('title')
				Branch
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			<a href="{{ route('users.show', $tenancy->user_id) }}">
				{{ $tenancy->owner->present()->fullName }}
			</a>
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->present()->dateCreated }}
			@slot('title')
				Registered
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->present()->dateUpdated }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
	</ul>
</div>