@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('calendars.index') }}">Calendars</a></li>
	<li class="is-active"><a>{{ $calendar->name }}</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $calendar->name }}
		@endslot
	@endcomponent

	@component('partials.sections.section')

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
	    	columnFormat: 'dddd D MMMM',
	    	events: '{{ route('events.feed', $calendar->id) }}',
	    	hiddenDays: [ 0 ],
	    	eventClick: function (event, jsEvent, view) {

				$.ajax({
				    type: 'POST',
				   	data: { event_id: event.id },
				    url: '{{ route('events.edit') }}',
				    success: function(data) {
	                    $('.modal').addClass('is-active');
	                    $('html').addClass('is-clipped');
				        $('#modal-content').html(data);
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
	                    $('.modal').addClass('is-active');
	                    $('html').addClass('is-clipped');
				        $('#modal-content').html(data);
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