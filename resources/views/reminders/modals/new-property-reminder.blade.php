<div class="modal fade" id="newPropertyReminderModal" tabindex="-1" role="dialog" aria-labelledby="newPropertyReminderModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form method="POST" action="{{ route('reminders.store') }}">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newPropertyReminderModal">Create New Reminder</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<input type="hidden" name="property_id" id="property_id" value="{{ $property->id }}" />

					@component('partials.form-group')
						@slot('label')
							Reminder Type
						@endslot
						<select name="reminder_type_id" id="reminder_type_id" class="form-control">
							@foreach (reminder_types('property') as $type)
								<option value="{{ $type->id }}">
									{{ $type->present()->selectName }}
								</option>
							@endforeach
						</select>
					@endcomponent

					@component('partials.form-group')
						@slot('label')
							Date Due
						@endslot
						@slot('help')
							Usually the expiry date of the previous reminder. Alerts will be given to users on and before this date.
						@endslot
						<input type="date" name="due_at" id="due_at" class="form-control" value="{{ old('due_at') }}" />
					@endcomponent

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					@component('partials.save-button')
						Create Reminder
					@endcomponent
				</div>
			</div>
		</form>
	</div>
</div>