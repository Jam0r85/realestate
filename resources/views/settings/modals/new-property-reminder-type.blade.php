<div class="modal fade" id="newPropertyReminderTypeModal" tabindex="-1" role="dialog" aria-labelledby="newPropertyReminderTypeModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form role="form" method="POST" action="{{ route('reminder-types.store') }}">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newPropertyReminderTypeModalLabel">Property Reminder Type</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					@component('partials.form-group')
						@slot('label')
							Parent
						@endslot
						<select name="parent_type" id="parent_type" class="form-control">
							<option value="">Please select..</option>
							<option value="properties">Properties</option>
							<option value="tenancies">Tenancies</option>
						</select>
					@endcomponent

					@component('partials.form-group')
						@slot('label')
							Name
						@endslot
						<input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
					@endcomponent

					@component('partials.form-group')
						@slot('label')
							Description
						@endslot
						<textarea name="description" id="description" rows="5" class="form-control">{{ old('description') }}</textarea>
					@endcomponent

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					@component('partials.save-button')
						Save
					@endcomponent
				</div>
			</div>
		</form>
	</div>
</div>