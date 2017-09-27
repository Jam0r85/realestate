@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					Expenses List
					<a href="{{ route('expenses.create') }}" class="btn btn-primary">
						<i class="fa fa-plus"></i> New Expense
					</a>
				</h1>
			</div>

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

		</div>
	</section>

	@if (isset($unpaid_expenses))
		@if (count($unpaid_expenses) && $expenses->currentPage() == 1)
			<section class="section">
				<div class="container">
					<div class="page-title">
						<h3 class="text-danger">
							Unpaid Expenses
						</h3>
					</div>

					<div class="row">
						<div class="col">
							@include('expenses.partials.unpaid-expenses-table', ['expenses' => $unpaid_expenses])
						</div>
					</div>
				</div>
			</section>
		@endif
	@endif

	<section class="section">
		<div class="container">

			@if (!session('expenses_search_term'))
				<div class="page-title">
					<h3 class="text-success">
						Paid Expenses
					</h3>
				</div>
			@endif

			<div class="row">
				<div class="col">
					@include('expenses.partials.paid-expenses-table')
				</div>
			</div>

		</div>
	</section>

@endsection