@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('users.index') }}">Users</a></li>
	<li class="is-active"><a>Create New User</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			Create New User
		@endslot
	@endcomponent

	<form action="{{ route('users.store') }}" method="POST">
		{{ csrf_field() }}

		@component('partials.sections.section')
			@slot('title')
				User Details
			@endslot

			@include('partials.errors-block')

			@include('users.partials.form')

			<button type="submit" class="button is-primary is-outlined">
				Create User
			</button>			
		@endcomponent

	</form>

@endsection