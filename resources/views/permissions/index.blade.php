@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('permissions.create') }}" class="btn btn-primary float-right">
			@icon('plus') New Permission
		</a>

		@component('partials.header')
			Permissions
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('permissions.partials.table')
		@include('partials.pagination', ['collection' => $permissions])

	@endcomponent

@endsection