@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('users.show', $user->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $user->name }}</h1>
			<h2 class="subtitle">Change Password</h2>

			<hr />

			<form role="form" method="POST" action="{{ route('users.update-password', $user->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<div class="field">
					<label class="label" for="password">New Password</label>
					<p class="control">
						<input type="password" class="input" name="password" />
					</p>
				</div>

				<div class="field">
					<label class="label" for="password_confirmation">Confirm New Password</label>
					<p class="control">
						<input type="password" class="input" name="password_confirmation" />
					</p>
				</div>

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Change Password
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection