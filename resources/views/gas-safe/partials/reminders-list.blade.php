<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Reminders History
	@endcomponent

	@if (count($gas->reminders))

		<ul class="list-group list-group-flush">

			@foreach ($gas->reminders as $reminder)

				<li class="list-group-item">
					{{ $reminder->body }}
				</li>

			@endforeach

		</ul>

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

		<p class="card-text">
			Select the recipients to send this reminder to.
		</p>

		<div class="form-group">
			@foreach ($gas->contractors()->hasEmail()->get() as $user)
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" name="contractors[]" value="{{ $user->id }}">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">
						<b>{{ $user->name }}</b> (contractor)
					</span>
				</label>
			@endforeach
			@foreach ($gas->property->owners()->hasEmail()->get() as $user)
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" name="contractors[]" value="{{ $user->id }}">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">
						<b>{{ $user->name }}</b> (owner)
					</span>
				</label>
			@endforeach
		</div>

		<div class="form-group">
			<label for="body">Message</label>
			<textarea name="body" id="body" class="form-control" rows="12"></textarea>
		</div>

		{{-- Check for any active tenancies and show the option to add their details to the reminder --}}
		@if ($tenancies = $gas->property->tenancies()->isActive()->get())
			<p>Include contact details for the tenants below?</p>
			@foreach ($tenancies as $tenancy)
				@foreach ($tenancy->tenants as $user)
					<div class="form-group">
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

		@component('partials.save-button')
			Send Reminder
		@endcomponent

	</div>

</div>