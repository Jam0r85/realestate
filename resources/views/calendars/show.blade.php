@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@include('calendars.partials.dropdown-menu')
		</div>

		@component('partials.header')
			{{ $calendar->name }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-fluid-container')

		<div id="alert" class="alert alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<span id="alertMessage"></span>
		</div>	

		@include('partials.errors-block')

		<div id="calendar"></div>

	@endcomponent

@endsection

@push('style')
	<link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
@endpush

@push('footer_scripts')
<script>
	$('#alert').hide();
	$(document).ready(function() {
	    $('#calendar').fullCalendar({
	    	allDaySlot: false,
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
	    	businessHours: [
	    		{
	    			dow: [ 1, 2, 3, 4, 5 ],
	    			start: '09:00',
	    			end: '17:00'
	    		},
	    		{
	    			dow: [ 6 ],
	    			start: '09:00',
	    			end: '16:00'
	    		}
	    	],
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

	    setInterval(function(){
	    	$('#calendar').fullCalendar('refetchEvents')
	    }, 30000);

	});
</script>
@endpush