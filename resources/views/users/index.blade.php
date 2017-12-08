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

		@if (isset($sections))
			<div class="nav nav-pills" id="v-pills-tab" role="tablist">

				@foreach ($sections as $key)
					<a class="nav-link @if (request('section') == str_slug($key)) active @elseif (!request('section') && $loop->first) active @endif" id="v-pills-{{ str_slug($key) }}-tab" data-toggle="pill" href="#v-pills-{{ str_slug($key) }}" role="tab">
						{{ $key }}
					</a>
				@endforeach

			</div>
		@endif

		<div class="tab-content" id="v-pills-tabContent">

			@if (isset($sections))
				@foreach ($sections as $key)
					@include('users.sections.index.' . str_slug($key))
				@endforeach
			@endif

			@if (isset($searchResults))
				@include('users.partials.users-table', ['users' => $searchResults])
			@endif

		</div>

	@endcomponent

@endsection