@extends('users.show.layout')

@section('sub-content')

	<form role="form" method="POST" action="{{ route('users.send-email', $user->id) }}">
		{{ csrf_field() }}

		@include('partials.errors-block')

		<div class="field">
			<label class="label" for="subject">Subject</label>
			<div class="control">
				<input type="text" name="subject" class="input" value="{{ old('subject') }}" />
			</div>
		</div>	

		<div class="field">
			<label class="label" for="message">Message</label>
			<div class="control">
				<textarea name="message" rows="8" class="textarea">{{ old('message') }}</textarea>
			</div>
		</div>

		<button type="submit" class="button is-primary is-outlined">
			Send E-Mail
		</button>

	</form>

@endsection