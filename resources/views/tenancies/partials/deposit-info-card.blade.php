<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Deposit
	@endcomponent

	@if (!$tenancy->deposit)
		<div class="card-body">
			<p class="card-text">
				No deposit has been recorded for this tenancy.
			</p>
		</div>
	@else
		<ul class="list-group list-group-flush">
			@component('partials.bootstrap.list-group-item')
				<span class="lead">
					{{ currency($tenancy->deposit->balance) }}
				</span>
				@slot('title')
					<span class="lead">
						Balance
					</span>
				@endslot
				@slot('style')
					@if ($tenancy->deposit->amount == $tenancy->deposit->balance)
						list-group-item-success
					@endif
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ currency($tenancy->deposit->amount) }}
				@slot('title')
					Amount
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ $tenancy->deposit->unique_id }}
				@slot('title')
					ID
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ $tenancy->deposit->lastPayment ? date_formatted($tenancy->deposit->lastPayment->created_at) : '-' }}
				@slot('title')
					Last Payment
				@endslot
			@endcomponent
		</ul>
	@endif
</div>