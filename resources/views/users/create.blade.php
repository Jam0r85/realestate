@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Register User
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-8">

				<div class="card mb-3">

					@component('partials.card-header')
						User Details
					@endcomponent

					<div class="card-body">

						<form action="{{ route('users.store') }}" method="POST">
							{{ csrf_field() }}

							@include('users.partials.form')

							<div class="form-group">
								<label for="password">Password <small>(optional)</small></label>
								<input type="password" name="password" id="password" class="form-control" />
							</div>

							<div class="form-group">
								<label for="password_confirmation">Confirm Password</label>
								<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" />
							</div>

							@component('partials.bootstrap.save-submit-button')
								Create User
							@endcomponent

						</form>

					</div>
				</div>

			</div>
			<div class="col-12 col-lg-4">

				<div class="card mb-3">

					@component('partials.card-header')
						Latest Users
					@endcomponent

					<div class="list-group list-group-flush">
						@foreach ($latestUsers as $user)
							<a href="{{ route('users.show', $user->id) }}" class="list-group-item list-group-item-action">
								{{ $user->present()->fullName }}
							</a>
						@endforeach
					</div>

			</div>
		</div>

	@endcomponent

@endsection