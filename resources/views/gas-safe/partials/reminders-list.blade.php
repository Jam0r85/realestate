<div class="card mb-3 border-info">

	@component('partials.bootstrap.card-header')
		Reminders History
		@slot('style')
			bg-info text-white
		@endslot
	@endcomponent

	@if (count($gas->reminders))

		@foreach ($gas->reminders as $reminder)

			@component('partials.bootstrap.card-header')
				<span class="float-right text-muted">
					{{ datetime_formatted($reminder->created_at) }}
				</span>
				{{ $reminder->recipient->name }}
			@endcomponent

			<div class="card-body">
				{!! $reminder->body !!}
			</div>

		@endforeach

	@else

		<div class="card-body">
			<div class="alert alert-warning mb-0">
				No reminders have been sent about this gas inspection.
			</div>
		</div>

	@endif

</div>

<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Send Reminder E-Mail
	@endcomponent

	<div class="card-body">

		<form method="POST" action="{{ route('gas-safe.send-reminder', $gas->id) }}">
			{{ csrf_field() }}

			<p class="card-text">
				Select the recipients to send this reminder to.
			</p>

			<div class="form-group">
				@foreach ($gas->contractors()->hasEmail()->get() as $user)
					<label class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="recipients[]" value="{{ $user->id }}">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">
							<b>{{ $user->name }}</b> (contractor)
						</span>
					</label>
				@endforeach
				@foreach ($gas->property->owners()->hasEmail()->get() as $user)
					<label class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="recipients[]" value="{{ $user->id }}">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">
							<b>{{ $user->name }}</b> (owner)
						</span>
					</label>
				@endforeach
			</div>

			{{-- Check for any active tenancies and show the option to add their details to the reminder --}}
			@if ($tenancies = $gas->property->tenancies()->isActive()->get())
				<p>Include contact details for the tenants below?</p>
				@foreach ($tenancies as $tenancy)
					@foreach ($tenancy->tenants as $user)
						<div class="form-group mb-0">
							<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" name="tenants[]" value="{{ $user->id }}">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">
									<b>{{ $user->name }}</b>
									{!! $user->email ? '<i class="fa fa-envelope pl-3 pr-2"></i>' . $user->email : '' !!}
									{!! $user->phone_number ? '<i class="fa fa-phone pl-3 pr-2"></i>' . $user->phone_number : '' !!}
								</span>
							</label>
						</div>
					@endforeach
				@endforeach
			@endif

			<div class="form-group mt-3">
				<label for="body">Message</label>
				<textarea name="body" id="body" class="form-control" rows="12"></textarea>
				<small class="form-text text-muted">
					Leave the message blank to use the default 'Please arrange for this..' message to be used. When being sent to the contractor this will include the full property address as well as the tenants details.
				</small>
			</div>

			@component('partials.save-button')
				Send Reminder
			@endcomponent

		</form>

	</div>

</div>