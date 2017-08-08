@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">New User</h1>

			<hr />

			@include('partials.errors-block')

			<form action="{{ route('users.store') }}" method="POST">
				{{ csrf_field() }}

				@include('users.partials.form')

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Create User
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection