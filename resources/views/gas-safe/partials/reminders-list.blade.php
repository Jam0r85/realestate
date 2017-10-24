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
		Send Reminder
	@endcomponent

	<div class="card-body">

		<div class="form-group">
			<label for="body">Message</label>
			<textarea name="body" id="body" class="form-control" rows="12"></textarea>
		</div>

		{{-- Check for any active tenancies and show the option to add their details to the reminder --}}
		@if ($tenancies = $gas->property->tenancies()->isActive()->exists())
			@foreach ($tenancies as $tenancy)
				<div class="form-group">
					<label class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">
							Include tenant contact details for the tenancy {{ $tenancy->name }}
						</span>
					</label>
				</div>
			@endif
		@endif

		@component('partials.save-button')
			Send Reminder
		@endcomponent

	</div>

</div>