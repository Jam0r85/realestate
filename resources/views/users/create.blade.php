@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>New User</h1>
			</div>

			@include('partials.errors-block')

			<form action="{{ route('users.store') }}" method="POST">
				{{ csrf_field() }}

				@include('users.partials.form')

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Create User
				</button>

			</form>

		</div>
	</section>

@endsection