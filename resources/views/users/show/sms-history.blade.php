<form method="POST" action="{{ route('sms.print') }}">
	{{ csrf_field() }}

	<div class="text-right">
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
							<div class="d-flex w-100 justify-content-between">
								<h5 class="mb-1">
									{{ $message->phone_number }}
								</h5>
								<div>
									<input type="checkbox" value="sms_print_ids[]" value="{{ $message->id }}" />
								</div>
							</div>
							<small class="mb-1">
								{{ $message->present()->timeSince('created_at') }}
							</small>
							<p class="mb-1">
								{{ $message->body }}
							</p>
							<small>
								{{ $message->status() }}
							</small>
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
							<div class="d-flex w-100 justify-content-between">
								<h5 class="mb-1">
									{{ $message->phone_number }}
								</h5>
								<div>
									<input type="checkbox" value="sms_print_ids[]" value="{{ $message->id }}" />
								</div>
							</div>
							<small class="mb-1">
								{{ $message->present()->timeSince('created_at') }}
							</small>
							<p class="mb-1">
								{{ $message->body }}
							</p>
							<small>
								<ul class="list-inline">
									<li class="list-inline-item">
										<a href="{{ route('sms.print', $message->id) }}">
											@icon('print') Print Message
										</a>
									</li>
								</ul>
							</small>
						</div>
					@endforeach
				</div>
			@endcomponent

		</div>
	</div>

</form>