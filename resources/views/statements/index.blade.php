@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Statements List
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		{{-- Statements search form --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('statements.search') }}
			@endslot
			@if (session('statements_search_term'))
				@slot('search_term')
					{{ session('statements_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End statements search form --}}

		<ul class="nav nav-pills">
			{!! (new Filter())->monthDropdown() !!}
			{!! (new Filter())->yearDropdown('App\Statement') !!}
			{!! Filter::unsentPill() !!}
			{!! Filter::clearButton() !!}
		</ul>

		@include('statements.partials.statements-table')
		@include('partials.pagination', ['collection' => $statements])

	@endcomponent

@endsection