@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">Paid Expenses</h1>

			<form role="form" method="POST" action="{{ route('expenses.search') }}">
				{{ csrf_field() }}

				<div class="field is-grouped">
					<div class="control">
						<a href="{{ route('expenses.create') }}" class="button is-primary is-outlined">
							<span class="icon is-small">
								<i class="fa fa-plus"></i>
							</span>
							<span>
								New Expense
							</span>
						</a>
					</div>
					<div class="control is-expanded">
						<input type="text" name="search_term" class="input" value="{{ session('search_term') }}" />
					</div>
					<div class="control">
						<button type="submit" class="button">
							<span class="icon is-small">
								<i class="fa fa-search"></i>
							</span>
							<span>
								Search
							</span>
						</button>
					</div>
				</div>
			</form>

			<hr />

			<table class="table is-striped is-fullwidth">
				<thead>
					<th>Name</th>
					<th>Contractors</th>
					<th>Property</th>
					<th>Cost</th>
					<th>Paid</th>
					<th>Invoice(s)</th>
				</thead>
				<tbody>
					@foreach ($expenses as $expense)
						<tr>
							<td>
								<a href="{{ route('expenses.show', $expense->id) }}">
									{{ $expense->name }}
								</a>
							</td>
							<td>
								@foreach ($expense->contractors as $user)
									<a href="{{ route('users.show', $user->id) }}">
										<span class="tag is-primary">
											{{ $user->name }}
										</span>
									</a>
								@endforeach
							</td>
							<td><a href="{{ route('properties.show', $expense->property->id) }}">{{ $expense->property->short_name }}</a></td>
							<td>{{ currency($expense->cost) }}</td>
							<td>{{ date_formatted($expense->paid_at) }}</td>
							<td>
								@if ($expense->hasInvoice())
									<span class="tag is-success">
										Yes
									</span>
								@else
									<span class="tag is-warning">
										No
									</span>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			@include('partials.pagination', ['collection' => $expenses])

		</div>
	</section>

@endsection