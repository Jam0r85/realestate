@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Register User
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

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

	@endcomponent

@endsection