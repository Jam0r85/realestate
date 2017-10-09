<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-user"></i> User's Information
	</div>
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ currency($payment->amount) }}
			@slot('title')
				Amount
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $payment->method->name }}
			@slot('title')
				Payment Method
			@endslot
		@endcomponent
	</ul>
</div>