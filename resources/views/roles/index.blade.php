@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('roles.create') }}" class="btn btn-primary float-right">
			@icon('plus') New Role
		</a>

		@component('partials.header')
			Roles
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('roles.partials.table')
		@include('partials.pagination', ['collection' => $roles])

	@endcomponent

@endsection