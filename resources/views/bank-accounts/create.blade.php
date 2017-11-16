@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Bank Account
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('bank-accounts.store') }}">
			{{ csrf_field() }}				

			@include('bank-accounts.partials.form')

			<div class="form-group">
				<label for="users">Users</label>
				<select name="users[]" id="users" class="form-control select2" multiple>
					@foreach (users() as $user)
						<option value="{{ $user->id }}">
							{{ $user->present()->selectName }}
						</option>
					@endforeach
				</select>
			</div>

			@component('partials.save-button')
				Create Bank Account
			@endcomponent

		</form>

	@endcomponent

@endsection