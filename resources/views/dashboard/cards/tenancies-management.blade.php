<div class="card mb-3">

	@component('partials.card-header')
		Tenancies Management
	@endcomponent

	<div class="list-group list-group-flush">
		<a href="{{ route('gas-safe.index') }}" class="list-group-item list-group-item-action">
			<span class="float-right">
				{{ $gas_expired }}
			</span>
			Gas Checks Expired
		</a>
	</div>
</div>