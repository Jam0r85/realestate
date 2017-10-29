@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				{{ $user->name }}
			@endcomponent

			@component('partials.sub-header')
				Update user e-mail
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<form method="POST" action="{{ route('users.update-email', $user->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			@include('partials.errors-block')

			@if ($user->email)

				<div class="mb-4">
					<div class="form-group">
						<label for="current_email">Current E-Mail</label>
						<input type="text" name="current_email" id="current_email" class="form-control" value="{{ $user->email }}" disabled />
					</div>

					<button type="submit" class="btn btn-danger" name="remove_email" value="true">
						<i class="fa fa-times"></i> Remove E-Mail
					</button>
				</div>

			@endif

			<div class="form-group">
				<label for="email">New E-Mail</label>
				<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" />
			</div>

			<div class="form-group">
				<label for="email_confirmation">Confirm New E-Mail</label>
				<input type="email" name="email_confirmation" id="email_confirmation" class="form-control" />
			</div>

			@component('partials.save-button')
				Update E-Mail
			@endcomponent

		</form>

	@endcomponent

@endsection