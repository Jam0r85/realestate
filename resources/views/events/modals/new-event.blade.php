<div class="modal fade" id="newEventModal" tabindex="-1" role="dialog" aria-labelledby="newEventModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">New Event</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="saveEventForm" method="POST" action="{{ route('events.store') }}">
				{{ csrf_field() }}
				<input type="hidden" name="calendar_id" value="{{ $calendar_id }}" />
				
				<div class="modal-body">

					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" name="title" class="form-control" required />
					</div>

					<div class="form-group">
						<label for="body">Message</label>
						<textarea name="body" class="form-control" rows="6"></textarea>
					</div>

					<div class="form-group">
						<label for="title">Start Date</label>
						<input type="datetime-local" name="start" class="form-control" required value="{{ $start }}" />
					</div>

					<div class="form-group">
						<label for="title">End Date</label>
						<input type="datetime-local" name="end" class="form-control" required value="{{ $end }}" />
					</div>

					<button type="submit" class="btn btn-primary">
						<i class="fa fa-save fa-fw"></i> Save Event
					</button>

				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">

	$( "#saveEventForm" ).submit(function( event ) {

        // process the form
        $.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serializeArray(),
			dataType: 'json',
			encode: true
        })
        .done(function(data) {
        	// close the modal window
			$('#newEventModal').modal('hide');
			// parse the data
			var alert = data.alert;
			// display the alert and the message
        	$('#alert').show().addClass(alert.class);
        	$('#alertMessage').html(alert.message);
        	// refetch the events
        	$('#calendar').fullCalendar('refetchEvents');
        });

		event.preventDefault();
	});

</script>