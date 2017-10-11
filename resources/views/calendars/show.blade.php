@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<div class="float-right">
				@include('calendars.partials.dropdown-menu')
			</div>
			<h1>{{ $calendar->name }}</h1>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div id="calendar"></div>

	@endcomponent

@endsection

@push('footer_scripts')
<script>
	$(document).ready(function() {

	    $('#calendar').fullCalendar({
	    	allDaySlot: true,
	    	header: {
	    		center: 'title',
	    		right: 'month,agendaWeek,agendaDay,listDay',
	    		left: 'today, prev, next'
	    	},
	    	height: 'auto',
	    	defaultView: 'agendaWeek',
	    	slotDuration: '00:15:00',
	    	slotLabelInterval: '01:00',
	    	minTime: '06:00',
	    	maxTime: '20:00',
	    	firstDay: '1',
	    	columnFormat: 'ddd DD, YYYY',
	    	events: '{{ route('events.feed', $calendar->id) }}',
	    	hiddenDays: [ 0 ],
	    	eventClick: function (event, jsEvent, view) {

				$.ajax({
				    type: 'POST',
				   	data: { event_id: event.id },
				    url: '{{ route('events.edit-modal') }}',
				    success: function(data) {
				    	$('#modalContainer').html(data);
				    	$('#editEventModal').modal('show');
				    },
				    error: function(data) {
				    	alert('Error accessing the Event Controller');
				    }
				});

	    	},
	    	dayClick: function (date, jsEvent, view) {

	    		var start = date.format();
	    		var end = date.add(30, 'm').format();

				$.ajax({
				    type: 'POST',
				   	data: { calendar_id: '{{ $calendar->id }}', start: start, end: end },
				    url: '{{ route('events.create') }}',
				    success: function(data) {
				    	$('#modalContainer').html(data);
				    	$('#newEventModal').modal('show');
				    },
				    error: function(data) {
				    	alert('Error accessing the Event Controller');
				    }
				});

	    	}
	    });

	});
</script>
@endpush