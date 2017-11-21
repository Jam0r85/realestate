@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				@slot('url')
					{{ route('users.show', $user->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $user->present()->fullName }}
		@endcomponent

		@component('partials.sub-header')
			Update user e-mail
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<form method="POST" action="{{ route('users.update-email', $user->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			@include('partials.errors-block')

			@if ($user->email)

				<div class="card mb-3">

					@component('partials.card-header')
						Current E-Mail
					@endcomponent

					<div class="card-body">

						<div class="form-group">
							<input type="text" name="current_email" id="current_email" class="form-control" value="{{ $user->email }}" disabled />
						</div>

						<button type="submit" class="btn btn-danger" name="remove_email" value="true">
							<i class="fa fa-times"></i> Remove E-Mail
						</button>

					</div>
				</div>

			@endif

			<div class="card mb-3">

				@component('partials.card-header')
					Change User E-Mail
				@endcomponent

				<div class="card-body">

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

				</div>
			</div>

		</form>

	@endcomponent

@endsection