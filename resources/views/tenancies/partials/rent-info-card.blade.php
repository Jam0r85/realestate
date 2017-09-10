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
				{{ currency($tenancy->rent_balance) }}
				@slot('title')
					Rent Balance
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
		</ul>
	@endif
</div>