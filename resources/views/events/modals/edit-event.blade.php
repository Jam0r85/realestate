<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Event</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form role="form" method="POST" action="{{ route('events.update', $event->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<div class="modal-body">

					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" name="title" class="form-control" required value="{{ $event->title }}" />
					</div>

					<div class="form-group">
						<label for="body">Message</label>
						<textarea name="body" class="form-control" rows="6">{{ $event->body }}</textarea>
					</div>

					<div class="form-group">
						<label for="title">Start Date</label>
						<input type="datetime-local" name="start" class="form-control" required value="{{ $event->start->format('Y-m-d\TH:i:s') }}" />
					</div>

					<div class="form-group">
						<label for="title">End Date</label>
						<input type="datetime-local" name="end" class="form-control" required value="{{ $event->end->format('Y-m-d\TH:i:s') }}" />
					</div>

					<div class="card border-danger">
						<div class="card-body">
							<h5 class="card-title">
								Delete Event
							</h5>
							<p class="card-text">
								You can delete this event by entering the word 'delete' in the field below.
							</p>

							<input type="text" name="delete_event" class="form-control" />

						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Update Event</button>
				</div>
			</form>
		</div>
	</div>
</div>