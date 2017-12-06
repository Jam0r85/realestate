<div class="card mb-3">

	@component('partials.card-header')
		Tenancies
	@endcomponent
	
	<div class="list-group list-group-flush">
		<a href="{{ route('tenancies.index', 'overdue') }}" class="list-group-item list-group-item-action">
			<span class="float-right">
				{{ $overdue_tenancies }}
			</span>
			Tenancies in arrears
		</a>
		<a href="{{ route('tenancies.index') }}" class="list-group-item list-group-item-action">
			<span class="float-right">
				{{ $active_tenancies }}
			</span>
			Active tenancies
		</a>
		<a href="{{ route('tenancies.index') }}" class="list-group-item list-group-item-action">
			<span class="float-right">
				{{ count($managed_tenancies) }}
			</span>
			Managed tenancies
		</a>
	</div>
</div>