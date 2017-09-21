<div class="modal">
	<form role="form" method="POST" action="{{ route('events.store') }}">
		{{ csrf_field() }}
		<div class="model-dialog" role="document">
			<div class="model-content">
				<div class="modal-header">
					<h5 class="modal-title">New Quick Event</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

						<input type="hidden" name="calendar_id" value="{{ $calendar_id }}" />

						@include('events.partials.form')

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">
						Save Changes
					</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Close
					</button>
				</div>
			</div>
		</div>
	</form>
</div>