@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>New Bank Account</h1>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('bank-accounts.store') }}">
				{{ csrf_field() }}				

				@include('bank-accounts.partials.form')

				<div class="form-group">
					<label for="users">Users</label>
					<select name="users[]" class="form-control select2" multiple>
						@foreach (users() as $user)
							<option value="{{ $user->id }}">{{ $user->name }}</option>
						@endforeach
					</select>
				</div>

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Create Bank Account
				</button>

			</form>

		</div>
	</section>

@endsection