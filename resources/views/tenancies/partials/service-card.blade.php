<div class="card mb-3">

	@component('partials.card-header')
		Service Details
	@endcomponent

	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			<a href="{{ route('services.show', $tenancy->service->id) }}">
				{{ $tenancy->present()->serviceName }}
			</a>
			@slot('title')
				Service
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->present()->serviceCharge }}
			@slot('title')
				Management Fee
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $tenancy->present()->serviceChargeInCurrency }}
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
			@if ($tenancy->hasCustomUserLettingFee())
				@slot('extra')
					<span class="text-danger">
						<strong>
							Custom Letting Fee
						</strong>
					</span>
					<ul class="list-unstyled float-right">
						@foreach ($tenancy->getCustomUserLettingFees() as $fee => $value)
							<li class="text-right">
								<span class="text-muted">
									{{ $value['user_name'] }}
								</span> - {{ currency($value['amount']) }}
							</li>
						@endforeach
					</ul>
				@endslot
			@endif
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{!! $tenancy->hasCustomUserLettingFee() ? '<s>' : '' !!}
				{{ currency($tenancy->getReLettingFee()) }}
			{!! $tenancy->hasCustomUserLettingFee() ? '</s>' : '' !!}
			@slot('title')
				Re-Letting Fee
			@endslot
			@if ($tenancy->hasCustomUserReLettingFee())
				@slot('extra')
					<span class="text-danger">
						<strong>
							Custom Re-Letting Fee
						</strong>
					</span>
					<ul class="list-unstyled float-right">
						@foreach ($tenancy->getCustomUserReLettingFees() as $fee => $value)
							<li class="text-right">
								<span class="text-muted">
									{{ $value['user_name'] }}
								</span> - {{ currency($value['amount']) }}
							</li>
						@endforeach
					</ul>
				@endslot
			@endif
		@endcomponent
	</ul>
</div>