@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			{{ isset($title) ? $title : 'Deposits List' }}
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.index-search', ['route' => 'deposit.search', 'session' => 'deposit_search_term'])

		<ul class="nav nav-pills">
			{!! Filter::archivePill() !!}
		</ul>
		
		@include('deposits.partials.deposits-table')

		@include('partials.pagination', ['collection' => $deposits])

	@endcomponent

@endsection