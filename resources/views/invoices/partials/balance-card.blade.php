<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-gbp"></i> Balances
	</div>
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ currency($invoice->total) }}
			@slot('title')
				Invoice Total
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ currency($invoice->total_net) }}
			@slot('title')
				Net Total
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ currency($invoice->total_tax) }}
			@slot('title')
				Tax Total
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ currency($invoice->total_payments) }}
			@slot('title')
				Payments Total
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ currency($invoice->total_balance) }}
			@slot('title')
				Remaining Balance
			@endslot
		@endcomponent
	</ul>
</div>