<div class="card mb-3 @if (!$tenancy->current_rent) bg-danger text-white @endif">
	<div class="card-header">
		<i class="fa fa-gbp"></i> Rent
	</div>
	@if (!$tenancy->current_rent)
		<div class="card-body">
			<b>
				No current rent amount set.
			</b><br />You can set one under the options dropdown.
		</div>
	@else
		<ul class="list-group list-group-flush">
			@component('partials.bootstrap.list-group-item')
				<span class="lead">
					{{ currency($tenancy->rent_balance) }}
				</span>
				@slot('title')
					<span class="lead">
						Rent Balance
					</span>
				@endslot
				@slot('style')
					@if ($tenancy->rent_balance < 0)
						list-group-item-danger
					@elseif ($tenancy->rent_balance >= $tenancy->current_rent->amount)
						list-group-item-success
					@endif
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ $tenancy->current_rent ? currency($tenancy->current_rent->amount) : '' }}
				@slot('title')
					Current Rent
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ $tenancy->current_rent ? date_formatted($tenancy->current_rent->starts_at) : '' }}
				@slot('title')
					Date From
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ date_formatted($tenancy->lastRentPayment->created_at) }}
				@slot('title')
					Last Payment
				@endslot
			@endcomponent
		</ul>
	@endif
</div>