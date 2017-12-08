@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('tenancies.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-plus"></i> New Tenancy
		</a>

		@component('partials.header')
			{{ isset($title) ? $title : 'Tenancies List' }}
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		{{-- Tenancies Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('tenancies.search') }}
			@endslot
			@if (session('tenancies_search_term'))
				@slot('search_term')
					{{ session('tenancies_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Tenancies Search --}}

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
					@include('tenancies.sections.index.' . str_slug($key))
				@endforeach
			@endif

			@if (isset($searchResults))
				@include('tenancies.partials.tenancies-table', ['tenancies' => $searchResults])
			@endif

		</div>

	@endcomponent

@endsection