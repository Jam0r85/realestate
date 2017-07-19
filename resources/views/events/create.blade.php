<div class="modal-content">
	<div class="box">

		<h3 class="title is-3">Quick Event</h3>

		<form role="form" method="POST" action="{{ route('events.store') }}">
			{{ csrf_field() }}

			<input type="hidden" name="calendar_id" value="{{ $calendar_id }}" />

			@include('events.partials.form')

			@component('partials.forms.buttons.save')
				Create Event
			@endcomponent

		</form>

	</div>
</div>