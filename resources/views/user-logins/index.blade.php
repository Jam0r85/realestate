@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			User Logins
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('user-logins.user-logins-table')

		@include('partials.pagination', ['collection' => $logins])

	@endcomponent

@endsection