@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $user->name }}</h1>
				<h3>Change Password</h3>
			</div>

			<form role="form" method="POST" action="{{ route('users.update-password', $user->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<div class="form-group">
					<label for="password">New Password</label>
					<input type="password" class="form-control" name="password" />
				</div>

				<div class="form-group">
					<label for="password_confirmation">Confirm New Password</label>
					<input type="password" class="form-control" name="password_confirmation" />
				</div>

				@component('partials.bootstrap.save-submit-button')
					Change Password
				@endcomponent

			</form>

		</div>
	</section>

@endsection