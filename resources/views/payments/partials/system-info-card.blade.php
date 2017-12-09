<div class="card mb-3">
	@component('partials.card-header')
		System Information
	@endcomponent
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $payment->owner->name }}
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($payment->created_at) }}
			@slot('title')
				Recorded
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($payment->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
	</ul>
</div>