@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Agreements
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.index-search', ['route' => 'agreements.search', 'session' => 'agreement_search_term'])

		<ul class="nav nav-pills">
			{!! Filter::archivePill() !!}
		</ul>

		@include('agreements.partials.agreements-table')
		@include('partials.pagination', ['collection' => $agreements])

	@endcomponent

@endsection