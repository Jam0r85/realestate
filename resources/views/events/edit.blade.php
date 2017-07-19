<div class="modal-content">
	<div class="box">

		<h3 class="title is-3">Edit Event</h3>

		<form role="form" method="POST" action="{{ route('events.update', $event->id) }}">
			{{ method_field('PUT') }}
			{{ csrf_field() }}

			@include('events.partials.form')

			@component('partials.forms.buttons.save')
				Update Event
			@endcomponent

		</form>

		@if (!$event->trashed())

			<hr />

			<div class="content">
				<p>Delete this event and hide it from the calendar.</p>
			</div>

			<form role="form" method="POST" action="{{ route('events.delete', $event->id) }}">
				{{ method_field('DELETE') }}
				{{ csrf_field() }}

				@component('partials.forms.buttons.save')
					Delete Event
				@endcomponent

			</form>

		@endif

	</div>
</div>