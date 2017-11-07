@extends('settings.layout')

@section('settings-content')

	@include('partials.errors-block')

	<form method="POST" action="{{ route('settings.update') }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}

		<div class="form-group">
			<label for="statement_send_time">Statement Send Time</label>
			<input type="time" class="form-control" name="statement_send_time" id="statement_send_time" value="{{ get_setting('statement_send_time') }}">
			<small class="form-text text-muted">
				The time each day that statements ready to be sent are automatically sent.
			</small>
		</div>

		@component('partials.save-button')
			Save Changes
		@endcomponent

	</form>

@endsection