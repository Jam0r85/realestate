<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Event {{ $event->id }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form role="form" method="POST" action="{{ route('events.update', $event->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<div class="modal-body">

					<div class="alert alert-info">
						Created by <b>{{ $event->owner->name }}</b>
					</div>

					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" name="title" class="form-control" required value="{{ $event->title }}" />
					</div>

					<div class="form-group">
						<label for="body">Message</label>
						<textarea name="body" class="form-control" rows="8">{{ $event->body }}</textarea>
					</div>

					<div class="form-group">
						<label for="title">Start Date</label>
						<input type="datetime-local" name="start" class="form-control" required value="{{ $event->start->format('Y-m-d\TH:i:s') }}" />
					</div>

					<div class="form-group">
						<label for="title">End Date</label>
						<input type="datetime-local" name="end" class="form-control" required value="{{ $event->end->format('Y-m-d\TH:i:s') }}" />
					</div>

					<div class="form-group">
						<label class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" name="all_day" value="1" @if ($event->all_day) checked @endif />
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description">Is this an all day event?</span>
						</label>
					</div>

					<button type="submit" class="btn btn-primary">
						<i class="fa fa-save fa-fw"></i> Update Event
					</button>

				</div>
			</form>
			<form role="form" method="POST" action="{{ route('events.destroy', $event->id) }}">
				{{ csrf_field() }}
				{{ method_field('DELETE') }}

				<div class="modal-body">

					<div class="card border-danger">
						<div class="card-body">
							<h5 class="card-title">
								Delete Event
							</h5>

							<p class="card-text">
								You can delete this event by entering the ID of the event into the field below.
							</p>

							<div class="form-group">
								<input type="text" name="confirmation" class="form-control" />
							</div>

							<button type="submit" class="btn btn-danger">
								<i class="fa fa-trash fa-fw"></i> Delete Event
							</button>

						</div>
					</div>

				</div>
			</form>
		</div>
	</div>
</div>