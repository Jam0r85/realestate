@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('users.show', $user->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $user->name }}</h1>
			<h2 class="subtitle">Edit Details</h2>

			<hr />

			@if (!$user->email)

				<div class="notification">
					This user does not have a valid e-mail address.
				</div>

			@else

				<form role="form" method="POST" action="{{ route('users.send-email', $user->id) }}">
					{{ csrf_field() }}

					@include('partials.errors-block')

					<div class="field">
						<label class="label" for="email">E-Mail</label>
						<div class="control">
							<input type="text" name="email" class="input" disabled value="{{ $user->email }}" />
						</div>
					</div>	

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

					<button type="submit" class="button is-primary">
						<span class="icon is-small">
							<i class="fa fa-envelope-open"></i>
						</span>
						<span>
							Send E-Mail Message
						</span>
					</button>

				</form>

			@endif

		</div>
	</section>

@endsection