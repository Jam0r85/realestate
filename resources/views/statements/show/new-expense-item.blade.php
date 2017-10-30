@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<a href="{{ route('statements.show', $statement->id) }}" class="button is-pulled-right">
			Return
		</a>

		@component('partials.header')
			Statement #{{ $statement->id }}
		@endcomponent

		@component('partials.sub-header')
			New expense item
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('statements.create-expense-item', $statement->id) }}">
			{{ csrf_field() }}
			<input type="hidden" name="property_id" value="{{ $statement->tenancy->property->id }}" />	

			<div class="card mb-3">

				@component('partials.card-header')
					Unpaid Expenses
				@endcomponent

				<div class="card-body">

					<table class="table table-striped table-hover table-responsive">
						<thead>
							<th></th>
							<th>Name</th>
							<th>Contractors</th>
							<th>Cost</th>
							<th>Balance</th>
						</thead>
						<tbody>
							@foreach ($statement->property->unpaid_expenses as $unpaid_expense)
								<tr>
									<td>
										<input type="number" step="any" name="expense_amount[]" class="form-control" />
										<input type="hidden" name="expense_id[]" value="{{ $unpaid_expense->id }}" />
									</td>
									<td>{{ $unpaid_expense->name }}</td>
									<td>{{ $unpaid_expense->contractor ? $unpaid_expense->contractor->name : '' }}</td>
									<td>{{ currency($unpaid_expense->cost) }}</td>
									<td>{{ currency($unpaid_expense->balance_amount) }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>

				</div>
			</div>

			@component('partials.save-submit')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

@endsection