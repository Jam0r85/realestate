@extends('layouts.pages.calendar')

@section('sub-content')

	@component('partials.sections.section')
		@slot('title')
			Calendar Settings
		@endslot

		@include('partials.errors-block')

		<form role="form" method="POST" action="{{ route('calendars.update', $calendar->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			@include('calendars.partials.form')

			@component('partials.forms.buttons.save')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

	@if (!$calendar->trashed())

		@component('partials.sections.section')
			@slot('title')
				Archive the Calendar
			@endslot

			<form role="form" method="POST" action="{{ route('calendars.archive', $calendar->id) }}">
				{{ csrf_field() }}

				<div class="content">
					<p>
						You can archive this calendar and prevent it from being used in future.
					</p>
				</div>

				@component('partials.forms.buttons.save')
					Archive Calendar
				@endcomponent

			</form>

		@endcomponent

	@else

		@component('partials.sections.section')
			@slot('title')
				Restore the Calendar
			@endslot

			<form role="form" method="POST" action="{{ route('calendars.restore', $calendar->id) }}">
				{{ csrf_field() }}

				<div class="content">
					<p>
						You can restore this calendar.
					</p>
				</div>

				@component('partials.forms.buttons.save')
					Reatore Calendar
				@endcomponent

			</form>

		@endcomponent

	@endif

@endsection