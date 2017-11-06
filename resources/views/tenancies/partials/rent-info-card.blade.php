<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Rent
	@endcomponent

	@if (!$tenancy->currentRent())

		<div class="card-body">
			<p class="card-text">
				No rent amount has been set for this tenancy.
			</p>
		</div>

	@else

		<ul class="list-group list-group-flush">
			@component('partials.bootstrap.list-group-item')
				<span class="lead">
					{{ currency($tenancy->getRentBalance()) }}
				</span>
				@slot('title')
					<span class="lead">
						Balance
					</span>
				@endslot
				@slot('style')
					@if ($tenancy->getRentBalance() < 0)
						list-group-item-danger
					@elseif ($tenancy->getRentBalance() > 0)
						list-group-item-success
					@endif
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ $tenancy->getCurrentRentAmount() }}
				@slot('title')
					Current Rent
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ $tenancy->currentRent ? date_formatted($tenancy->currentRent->starts_at) : '-' }}
				@slot('title')
					Date From
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ $tenancy->latestRentPayment() ? date_formatted($tenancy->latestRentPayment()->created_at) : '-' }}
				@slot('title')
					Last Payment
				@endslot
			@endcomponent
		</ul>

	@endif

</div>