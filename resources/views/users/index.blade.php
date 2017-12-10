@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('users.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-user-plus"></i> Register User
		</a>

		@component('partials.header')
			{{ $title }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		{{-- Users Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('users.search') }}
			@endslot
			@if (session('users_search_term'))
				@slot('search_term')
					{{ session('users_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Users Search --}}

		<ul class="nav nav-pills">
			{!! Filter::archivePill() !!}
		</ul>

		@include('users.partials.users-table')
		@include('partials.pagination', ['collection' => $users])

	@endcomponent

@endsection