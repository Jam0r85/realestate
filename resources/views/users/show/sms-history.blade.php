<form method="POST" action="{{ route('sms.print') }}" target="_blank">
	{{ csrf_field() }}

	<div class="text-right mb-2">
		<button type="submit" class="btn btn-secondary">
			@icon('print') Print Messages
		</button>
	</div>

	<div class="row">
		<div class="col-12 col-lg-6">

			@component('partials.card')
				@slot('header')
					@icon('sent') Messages <b>sent</b> to {{ $user->present()->fullName }}
				@endslot
				<div class="list-group list-group-flush">
					@foreach ($user->smsSent as $message)
						<div class="float-right">
							
						</div>
						<div class="list-group-item flex-column align-items-start">
							<div class="float-right">
								<input type="checkbox" name="sms_print_ids[]" value="{{ $message->id }}" />
							</div>
							<p class="mb-1">
								{{ $message->body }}
							</p>
							<div class="d-flex w-100 justify-content-between">
								<small>
									{{ $message->status() }}
								</small>
								<small>
									{{ $message->present()->timeSince('created_at') }}
								</small>
							</div>
						</div>
					@endforeach
				</div>
			@endcomponent

		</div>
		<div class="col-12 col-lg-6">

			@component('partials.card')
				@slot('header')
					@icon('received') Messages <b>received</b> from {{ $user->present()->fullName }}
				@endslot
				<div class="list-group list-group-flush">
					@foreach ($user->smsReceived as $message)
						<div class="list-group-item flex-column align-items-start">
							<div class="float-right">
								<input type="checkbox" name="sms_print_ids[]" value="{{ $message->id }}" />
							</div>
							<p class="mb-1">
								{{ $message->body }}
							</p>
							<div class="d-flex w-100 justify-content-between">
								<small>
									{{ $message->present()->timeSince('created_at') }}
								</small>
							</div>
						</div>
					@endforeach
				</div>
			@endcomponent

		</div>
	</div>

</form>