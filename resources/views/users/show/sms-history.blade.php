<div class="row">
	<div class="col-12 col-lg-6">

		@component('partials.card')
			@slot('header')
				SMS Messages Sent
			@endslot

			<div class="list-group list-group-flush">
				@foreach ($user->smsSent as $message)
					<div class="list-group-item flex-column align-items-start">
						<p class="mb-1">
							{{ $message->body }}
						</p>
						<small>{{ $message->status }}</small>
					</div>
				@endforeach
			</div>
		@endcomponent

	</div>
</div>