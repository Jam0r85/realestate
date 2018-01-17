<div class="row mb-3">
	<div class="col-12 col-lg-4">

		@include('tenancies.partials.rent-card')

	</div>
	<div class="col-12 col-lg-4">

		@include('tenancies.partials.deposit-card')

	</div>
</div>

<div class="card mb-3">
	@component('partials.card-header')
		Tenants
	@endcomponent

	@include('users.partials.users-table', ['users' => $tenancy->users])
</div>

@component('partials.card')
	@slot('header')
		Tenancy Details
	@endslot
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->service->name }}
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
			{{ $tenancy->service->present()->monthlyChargeFormatted }} 
			<span class="badge badge-dark">
				{{ $tenancy->present()->monthlyServiceChargeCost }}
			</span>
			@slot('title')
				Monthly Service Charge
			@endslot
		@endcomponent
		@if (count($tenancy->discounts))
			@component('partials.bootstrap.list-group-item')
				<ul>
					@foreach ($tenancy->discounts as $discount)
						<li>
							{{ $discount->name }} - {{ $discount->amount }}
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
			<a href="{{ route('users.show', $tenancy->owner->id) }}">
				{{ $tenancy->owner->present()->fullName }}
			</a>
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($tenancy->created_at) }}
			@slot('title')
				Registered
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ datetime_formatted($tenancy->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
	</ul>
</div>