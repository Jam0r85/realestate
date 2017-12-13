<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Invoice Amounts
	@endcomponent

	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ currency($invoice->net) }}
			@slot('title')
				Net
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ currency($invoice->tax) }}
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
			{{ currency($invoice->present()->paymentsTotal) }}
			@slot('title')
				Payments Total
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ currency($invoice->present()->remainingBalanceTotal) }}
			@slot('title')
				Remaining Balance
			@endslot
		@endcomponent
	</ul>
</div>