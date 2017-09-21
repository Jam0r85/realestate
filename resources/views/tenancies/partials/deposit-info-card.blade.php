<div class="card mb-3 @if (!$tenancy->deposit) bg-danger text-white @endif">
	<div class="card-header">
		<i class="fa fa-gbp"></i> Deposit
	</div>
	@if (!$tenancy->deposit)
		<div class="card-body">
			No deposit has been recorded for this tenancy.
		</div>
	@else
		<ul class="list-group list-group-flush">
			@component('partials.bootstrap.list-group-item')
				{{ currency($tenancy->deposit->amount) }}
				@slot('title')
					Amount
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ currency($tenancy->deposit->balance) }}
				@slot('title')
					Balance
				@endslot
			@endcomponent
		</ul>
	@endif
</div>