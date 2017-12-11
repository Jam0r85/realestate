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

		@include('partials.index-search', ['route' => 'properties.search', 'session' => 'property_search_term'])

		<ul class="nav nav-pills">
			{!! Filter::archivePill() !!}
		</ul>

		@include('properties.partials.properties-table')
		@include('partials.pagination', ['collection' => $properties])

	@endcomponent

@endsection