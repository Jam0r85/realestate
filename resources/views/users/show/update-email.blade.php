@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $user->name }}</h1>
				<h2>Update E-Mail</h2>
			</div>

			<hr />

			<form role="form" method="POST" action="{{ route('users.update-email', $user->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				@include('partials.errors-block')

				<div class="form-group">
					<label for="email">New E-Mail</label>
					<input type="email" name="email" class="form-control" value="{{ old('email') }}" />
				</div>

				<div class="form-group">
					<label for="email_confirmation">Confirm New E-Mail</label>
					<input type="email" name="email_confirmation" class="form-control" />
				</div>

				@component('partials.bootstrap.save-submit-button')
					Update E-Mail
				@endcomponent

				@if ($user->email)
					<button type="submit" class="btn btn-danger" name="remove_email" value="true">
						<i class="fa fa-times"></i> Remove E-Mail
					</button>

					<div class="alert alert-danger mt-3">
						<strong>Important!</strong>
						Removing this user's e-mail address would prevent them from logging in.
					</div>
				@endif

			</form>

		</div>
	</section>

@endsection