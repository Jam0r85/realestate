@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('properties.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-plus"></i> New Property
		</a>

		@component('partials.header')
			{{ $title }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		{{-- Properties Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('properties.search') }}
			@endslot
			@if (session('properties_search_term'))
				@slot('search_term')
					{{ session('properties_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Properties Search --}}

		<ul class="nav nav-pills">
			<li class="nav-item">
				<a class="nav-link @if (!request('archived')) active @endif" href="{{ Filter::link(['archived' => null]) }}">
					Active
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (request('archived') == 'true') active @endif" href="{{ Filter::link(['archived' => 'true']) }}">
					Archived
				</a>
			</li>
		</ul>

		@include('properties.partials.properties-table')
		@include('partials.pagination', ['collection' => $properties])

	@endcomponent

@endsection