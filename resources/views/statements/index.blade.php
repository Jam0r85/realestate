@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Statements List
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.index-search', ['route' => 'statements.search', 'session' => 'statement_search_term'])

		<ul class="nav nav-pills">
			{!! (new Filter())->monthDropdown() !!}
			{!! (new Filter())->yearDropdown('App\Statement') !!}
			{!! Filter::sentPill() !!}
			{!! Filter::unsentPill() !!}
			{!! Filter::archivePill() !!}
			{!! Filter::clearButton() !!}
		</ul>

		@include('statements.partials.statements-table')
		@include('partials.pagination', ['collection' => $statements])

	@endcomponent

@endsection