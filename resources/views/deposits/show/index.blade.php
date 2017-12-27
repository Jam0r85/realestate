<div class="card mb-3">
	@component('partials.card-header')
		Deposit Details
	@endcomponent
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			<a href="{{ route('tenancies.show', $deposit->tenancy_id) }}">
				{{ $deposit->tenancy->present()->name }}
			</a>
			@slot('title')
				Tenancy
			@endslot
		@endcomponent
	</ul>
</div>