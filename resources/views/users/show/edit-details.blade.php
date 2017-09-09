@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $user->name }}</h1>
				<h3>Edit personal details</h3>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('users.update', $user->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}			

				@include('users.partials.form')

				@component('partials.bootstrap.save-submit-button')
					Save Changes
				@endcomponent

			</form>

		</div>
	</section>

@endsection