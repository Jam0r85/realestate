@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('users.show', $user->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $user->name }}</h1>
			<h2 class="subtitle">Update E-Mail</h2>

			<hr />

			<form role="form" method="POST" action="{{ route('users.update-email', $user->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				@include('partials.errors-block')

				@if ($user->email)
					<div class="field">
						<label class="label" for="current_email">Current E-Mail</label>
						<p class="control">
							<input type="email" disabled name="current_email" class="input" value="{{ $user->email }}" />
						</p>
					</div>

					<div class="field">
						<label class="checkbox">
							<input type="checkbox" name="remove_email" value="true" />
							Do you want to remove this user's E-Mail?
						</label>
					</div>
				@endif

				<div class="field">
					<label class="label" for="email">New E-Mail</label>
					<p class="control">
						<input type="email" name="email" class="input" value="{{ old('email') }}" />
					</p>
				</div>

				<div class="field">
					<label class="label" for="email_confirmation">Confirm New E-Mail</label>
					<p class="control">
						<input type="email" name="email_confirmation" class="input" value="" />
					</p>
				</div>

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Update E-Mail
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection