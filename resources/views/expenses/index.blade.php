@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

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

	@endcomponent

	@if (isset($unpaid_expenses))

		{{-- We only show the unpaid expenses on the first page --}}
		@if (count($unpaid_expenses) && $expenses->currentPage() == 1)

			@component('partials.bootstrap.section-with-container')

				<div class="page-title">
					<h2 class="text-danger">
						Unpaid Expenses
					</h2>
				</div>

				<table class="table table-striped table-hover table-responsive">
					<thead>
						<th>Name</th>
						<th>Property</th>
						<th>Contractors</th>
						<th>Cost</th>
						<th>Balance</th>
						<th><i class="fa fa-upload"></i></th>
					</thead>
					<tbody>
						@foreach ($expenses as $expense)
							<tr>
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
								<td>{{ implode(', ', $expense->contractors->pluck('name')->toArray()) }}</td>
								<td>{{ currency($expense->cost) }}</td>
								<td>{{ currency($expense->remaining_balance) }}</td>
								<td>
									@if (count($expense->invoices))
										<i class="fa fa-check"></i>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

			@endcomponent

		@endif

	@endif

	@component('partials.bootstrap.section-with-container')

			@if (!session('expenses_search_term'))
				<div class="page-title">
					<h2 class="text-success">
						Paid Expenses
					</h2>
				</div>
			@endif

			<table class="table table-striped table-hover table-responsive">
				<thead>
					<th>Name</th>
					<th>Property</th>
					<th>Contractors</th>
					<th>Cost</th>
					<th>Paid</th>
					<th><i class="fa fa-upload"></i></th>
				</thead>
				<tbody>
					@foreach ($expenses as $expense)
						<tr>
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
							<td>{{ implode(', ', $expense->contractors->pluck('name')->toArray()) }}</td>
							<td>{{ currency($expense->cost) }}</td>
							<td>{{ date_formatted($expense->paid_at) }}</td>
							<td>
								@if (count($expense->invoices))
									<i class="fa fa-check"></i>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

	@endcomponent

@endsection