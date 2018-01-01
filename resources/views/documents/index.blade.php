@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			@if (isset($title))
				{{ $title }}
			@else
				Documents
			@endif
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.index-search', ['route' => 'documents.search', 'session' => 'document_search_term'])

		<ul class="nav nav-pills">
			{!! Filter::archivePill() !!}
		</ul>

		@include('documents.partials.table')
		@include('partials.pagination', ['collection' => $documents])

	@endcomponent

@endsection