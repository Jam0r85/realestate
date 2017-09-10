<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-cogs"></i> Service
	</div>
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
				Service Charge
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ currency($tenancy->service_charge_amount) }}
			@slot('title')
				Service Charge Amount
			@endslot
		@endcomponent
	</ul>
</div>