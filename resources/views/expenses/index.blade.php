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

		{{-- Expenses Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('expenses.search') }}
			@endslot
			@if (session('expenses_search_term'))
				@slot('search_term')
					{{ session('expenses_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Expenses Search --}}

		<ul class="nav nav-pills">
			{!! Filter::paidPill() !!}
			{!! Filter::unpaidPill() !!}
		</ul>

		@include('expenses.partials.expenses-table')
		@include('partials.pagination', ['collection' => $expenses])

	@endcomponent

@endsection