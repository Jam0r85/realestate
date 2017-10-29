<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Service Details
	@endcomponent

	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->service->name }}
			@slot('title')
				Service
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->service_charge_formatted }}
			@slot('title')
				Management Fee
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ currency($tenancy->service_charge_amount) }}
			@slot('title')
				Management Fee Amount
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{!! $tenancy->hasCustomUserLettingFee() ? '<s>' : '' !!}
				{{ currency($tenancy->getLettingFee()) }}
			{!! $tenancy->hasCustomUserLettingFee() ? '</s>' : '' !!}
			@slot('title')
				Letting Fee
			@endslot
			@slot('extra')
				@if ($tenancy->hasCustomUserLettingFee())
					<span class="text-danger">
						<strong>
							Custom Letting Fee
						</strong>
					</span>
				@endif
				@if ($tenancy->hasCustomUserLettingFee())
					<ul class="list-unstyled float-right">
						@foreach ($tenancy->getCustomUserLettingFees() as $fee => $value)
							<li class="text-right">
								<span class="text-muted">
									{{ $value['user_name'] }}
								</span> - {{ currency($value['amount']) }}
							</li>
						@endforeach
					</ul>
				@endif
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ currency($tenancy->getReLettingFee()) }}
			@slot('title')
				Re-Letting Fee
			@endslot
		@endcomponent
	</ul>
</div>