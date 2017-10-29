<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Invoice Amounts
	@endcomponent

	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ currency($invoice->total_net) }}
			@slot('title')
				Net
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ currency($invoice->total_tax) }}
			@slot('title')
				Tax
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ currency($invoice->total) }}
			@slot('title')
				Total
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