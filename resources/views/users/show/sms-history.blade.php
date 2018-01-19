<div class="row">
	<div class="col-12 col-lg-6">

		@component('partials.card')
			@slot('header')
				Messages <b>sent</b> to {{ $user->present()->fullName }}
			@endslot

			<div class="list-group list-group-flush">
				@foreach ($user->smsSent as $message)
					<div class="list-group-item flex-column align-items-start">
						<div class="d-flex w-100 justify-content-between">
							<h5 class="mb-1">
								{{ $message->phone_number }}
							</h5>
							<small>
								{{ $message->present()->timeSince('created_at') }}
							</small>
						</div>
						<p class="mb-1">
							{{ $message->body }}
						</p>
						<small>{{ $message->status() }}</small>
					</div>
				@endforeach
			</div>
		@endcomponent

	</div>
	<div class="col-12 col-lg-6">

		@component('partials.card')
			@slot('header')
				Messages <b>received</b> from {{ $user->present()->fullName }}
			@endslot

		@endcomponent

	</div>
</div>