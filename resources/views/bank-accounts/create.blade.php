@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Bank Account
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('bank-accounts.store') }}">
			{{ csrf_field() }}	

			<div class="card mb-3">
				@component('partials.card-header')
					Bank Account Details
				@endcomponent
				<div class="card-body">			

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

				</div>
				<div class="card-footer">

					@component('partials.save-button')
						Create Bank Account
					@endcomponent

				</div>
			</div>

		</form>

	@endcomponent

@endsection