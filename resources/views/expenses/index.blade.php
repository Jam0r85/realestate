@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('expenses.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-plus"></i> New Expense
		</a>

		@component('partials.header')
			{{ isset($title) ? $title : 'Expenses List' }}
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.index-search', ['route' => 'expenses.search', 'session' => 'expense_search_term'])

		<ul class="nav nav-pills">
			{!! Filter::paidPill() !!}
			{!! Filter::unpaidPill() !!}
		</ul>

		@include('expenses.partials.expenses-table')
		@include('partials.pagination', ['collection' => $expenses])

	@endcomponent

@endsection