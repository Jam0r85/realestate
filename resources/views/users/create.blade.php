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

	@component('partials.sections.section')

		@include('partials.errors-block')

		<form action="{{ route('users.store') }}" method="POST">
			{{ csrf_field() }}

			@include('users.partials.form')

			@component('partials.forms.buttons.primary')
				Create User
			@endcomponent

		</form>

	@endcomponent

@endsection