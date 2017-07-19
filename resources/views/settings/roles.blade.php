@extends('settings.template')

@section('sub-content')

	@component('partials.sections.section-no-container')
		@slot('title')
			Branch Roles List
		@endslot

		@include('roles.partials.table', ['roles' => $roles])

	@endcomponent

	<form role="form" method="POST" action="{{ route('roles.store') }}">
		{{ csrf_field() }}

		@component('partials.sections.section-no-container')
			@slot('title')
				New Role
			@endslot
			@slot('saveButton')
				Create Role
			@endslot

			@include('partials.errors-block')

			@include('roles.partials.form')

		@endcomponent

	</form>

@endsection