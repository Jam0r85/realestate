<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-gbp"></i> Payment Information
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
		@component('partials.bootstrap.list-group-item')
			{{ $payment->parent->name }}
			@slot('title')
				Tenancy
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $payment->parent->property->short_name }}
			@slot('title')
				Property
			@endslot
		@endcomponent
	</ul>
</div>