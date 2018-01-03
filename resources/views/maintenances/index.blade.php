@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('maintenances.create') }}" class="btn btn-primary float-right">
			@icon('plus') New Issue
		</a>

		@component('partials.header')
			Maintenances
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.index-search', ['route' => 'maintenances.search', 'session' => 'maintenance_search_term'])

		<ul class="nav nav-pills">
			{!! Filter::archivePill() !!}
		</ul>

		@include('maintenances.partials.table')
		@include('partials.pagination', ['collection' => $issues])

	@endcomponent

@endsection