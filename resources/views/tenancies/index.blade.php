@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('tenancies.create') }}" class="btn btn-primary float-right">
				<i class="fa fa-plus"></i> New Tenancy
			</a>

			@component('partials.header')
				{{ $title }}
			@endcomponent

		</div>

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

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('tenancies.partials.tenancies-table')

		@include('partials.pagination', ['collection' => $tenancies])

	@endcomponent

@endsection