@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Register User
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-8">

				<form action="{{ route('users.store') }}" method="POST">
					{{ csrf_field() }}

					<div class="card mb-3">
						@component('partials.card-header')
							User E-Mail
						@endcomponent
						<div class="card-body">

							<p class="card-text">
								A user requires a valid, unqiue e-mail address before they can login to the website.
							</p>

							@component('partials.form-group')
								@slot('label')
									E-Mail Address
								@endslot
								<input type="email" name="email" class="form-control" value="{{ old('email') }}" />
							@endcomponent

						</div>
					</div>

					<div class="card mb-3">
						@component('partials.card-header')
							User Details
						@endcomponent
						<div class="card-body">

							@include('users.partials.form')

						</div>
						<div class="card-footer">
							@component('partials.save-button')
								Create User
							@endcomponent
						</div>
					</div>

					<div class="card mb-3">
						@component('partials.card-header')
							User Password
						@endcomponent
						<div class="card-body">

							@component('partials.form-group')
								@slot('label')
									Password
								@endslot
								@slot('help')
									You can set manually set a password for this user
								@endslot
								<input type="password" name="password" id="password" class="form-control" />
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Password Confirmation
								@endslot
								<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" />
							@endcomponent

						</div>
						<div class="card-footer">
							@component('partials.save-button')
								Create User
							@endcomponent
						</div>
					</div>

				</form>

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
		</div>

	@endcomponent

@endsection