@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">{{ $expense->name }}</h1>
			<h2 class="subtitle">
				<a href="{{ route('properties.show', $expense->property_id) }}">
					{{ $expense->property->name }}
				</a>
			</h2>

			<div class="control">
				<a href="{{ route('expenses.show', [$expense->id, 'contractors']) }}" class="button is-warning">
					<span class="icon is-small">
						<i class="fa fa-edit"></i>
					</span>
					<span>
						Edit Contractors
					</span>
				</a>
				@foreach ($expense->contractors as $user)
					<a href="{{ route('users.show', $user->id) }}">
						<span class="tag is-medium is-primary">
							{{ $user->name }}
						</span>
					</a>
				@endforeach
			</div>

			<hr />

			<div class="columns">
				<div class="column is-4">

					@include('expenses.partials.layout-paid-card')

					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								Expense Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="has-text-grey">Cost</td>
								<td class="has-text-right">{{ currency($expense->cost) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Balance Remaining</td>
								<td class="has-text-right">{{ currency($expense->balance_amount) }}</td>
							</tr>
						</table>
					</div>

					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								System Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="has-text-grey">Created On</td>
								<td class="has-text-right">{{ date_formatted($expense->created_at) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Last Updated On</td>
								<td class="has-text-right">{{ datetime_formatted($expense->updated_at) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Created By</td>
								<td class="has-text-right">
									<a href="{{ route('users.show', $expense->user_id) }}">
										{{ $expense->owner->name }}
									</a>
								</td>
							</tr>
						</table>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('expenses.show', [$expense->id, 'delete']) }}">
								Delete Expense
							</a>
						</footer>
					</div>

				</div>
				<div class="column">

					<div class="card mb-2">
						<div class="card-content">

							<h3 class="title">Payments</h3>
							<h5 class="subtitle">List of payments made towards this expense from rental statements.</h5>

							<table class="table is-striped is-fullwidth">
								<thead>
									<th>Date</th>
									<th>Statement</th>
									<th>Amount</th>
								</thead>
								<tbody>
									@foreach ($expense->statements as $statement)
										<tr>
											<td>{{ date_formatted($statement->created_at) }}</td>
											<td>
												<a href="{{ route('statements.show', $statement->id) }}">
													Statement #{{ $statement->id }}
												</a>
											</td>
											<td>{{ currency($statement->pivot->amount) }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>

						</div>
					</div>

				</div>
			</div>

		</div>
	</section>

@endsection