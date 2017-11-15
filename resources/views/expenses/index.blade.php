@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('expenses.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-plus"></i> New Expense
		</a>

		@component('partials.header')
			Expenses List
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

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

		@if (isset($unpaid_expenses))

			{{-- We only show the unpaid expenses on the first page --}}
			@if (count($unpaid_expenses) && $expenses->currentPage() == 1)

				<div class="card mb-3">

					@component('partials.card-header')
						Unpaid Expenses
					@endcomponent

					@component('partials.table')
						@slot('header')
							<th>Added</th>
							<th>Name</th>
							<th>Property</th>
							<th>Contractor</th>
							<th>Cost</th>
							<th>Balance</th>
							<th><i class="fa fa-upload"></i></th>
						@endslot
						@slot('body')
							@foreach ($unpaid_expenses as $expense)
								@if (!$expense->isPaid())
									<tr>
										<td>{{ date_formatted($expense->created_at) }}</td>
										<td>
											<a href="{{ route('expenses.show', $expense->id) }}" title="{{ $expense->name }}">
												{!! truncate($expense->name) !!}
											</a>
										</td>
										<td>
											<a href="{{ route('properties.show', $expense->property->id) }}" title="{{ $expense->property->short_name }}">
												{!! truncate($expense->property->short_name) !!}
											</a>
										</td>
										<td>{{ $expense->contractor ? $expense->contractor->name : '' }}</td>
										<td>{{ currency($expense->cost) }}</td>
										<td>{{ currency($expense->remaining_balance) }}</td>
										<td>
											@if (count($expense->documents))
												<i class="fa fa-check"></i>
											@endif
										</td>
									</tr>
								@endif
							@endforeach
						@endslot
					@endcomponent

				</div>

			@endif

		@endif

		@if (!session('expenses_search_term'))
			<div class="page-title">

				@component('partials.sub-header')
					Paid Expenses
				@endcomponent

			</div>
		@endif

		@include('expenses.partials.expenses-table')			

		@include('partials.pagination', ['collection' => $expenses])

	@endcomponent

@endsection