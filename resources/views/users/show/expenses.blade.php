@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('users.show', $user->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $user->name }}</h1>
			<h2 class="subtitle">Expenses linked to this user</h2>

			<hr />

			<table class="table is-striped is-fullwidth">
				<thead>
					<th>Name</th>
					<th>Property</th>
					<th>Cost</th>
					<th>Balance</th>
					<th>Date</th>
				</thead>
				<tbody>
					@foreach ($user->expenses()->paginate() as $expense)
						<tr>
							<td>
								<a href="{{ route('expenses.show', $expense->id) }}">
									{{ $expense->name }}
								</a>
							</td>
							<td>
								<a href="{{ route('properties.show', $expense->property->id) }}">
									{{ $expense->property->short_name }}
								</a>
							</td>
							<td>{{ currency($expense->cost) }}</td>
							<td>{{ currency($expense->balance_amount) }}</td>
							<td>{{ date_formatted($expense->created_at) }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			@include('partials.pagination', ['collection' => $user->expenses()->paginate()])

		</div>
	</section>

@endsection