@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('statements.show', $statement->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">Statement #{{ $statement->id}}</h1>
			<h2 class="subtitle">New expense item</h2>

			<hr />

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('statements.create-expense-item', $statement->id) }}">
				{{ csrf_field() }}
				<input type="hidden" name="property_id" value="{{ $statement->tenancy->property->id }}" />	

				<div class="card mb-2">
					<div class="card-content">

						<h3 class="title">Unpaid expenses</h3>
						<h5 class="subtitle">List of unpaid expenses linked to the property of this statement.</h5>

						<table class="table is-striped is-fullwidth">
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
											<div class="control has-icons-left">
												<input type="number" step="any" name="expense_amount[]" class="input" />
												<span class="icon is-small is-left">
													<i class="fa fa-gbp"></i>
												</span>
											</div>
											<input type="hidden" name="expense_id[]" value="{{ $unpaid_expense->id }}" />
										</td>
										<td>{{ $unpaid_expense->name }}</td>
										<td>
											@foreach ($unpaid_expense->contractors as $user)
												<a href="{{ route('users.show', $user->id) }}">
													<span class="tag is-primary">
														{{ $user->name }}
													</span>
												</a>
											@endforeach
										</td>
										<td>{{ currency($unpaid_expense->cost) }}</td>
										<td>{{ currency($unpaid_expense->balance_amount) }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>

					</div>
				</div>

				@include('expenses.partials.form')

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Add &amp; Create Item(s)
					</span>
				</button>
			</form>

		</div>
	</section>

@endsection