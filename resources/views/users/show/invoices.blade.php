@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('users.show', $user->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $user->name }}</h1>
			<h2 class="subtitle">Invoices linked to this user</h2>

			<hr />

			<table class="table is-striped is-fullwidth">
				<thead>
					<th>Created</th>
					<th>Number</th>
					<th>Property</th>
					<th>Amount</th>
					<th>Balance</th>
					<th>Status</th>
				</thead>
				<tbody>
					@foreach ($user->invoices()->paginate() as $invoice)
						<tr>
							<td>{{ date_formatted($invoice->created_at) }}</td>
							<td>
								<a href="{{ route('invoices.show', $invoice->id) }}">
									{{ $invoice->number }}
								</a>
							</td>
							<td>
								<a href="{{ route('properties.show', $invoice->property->id) }}">
									{{ $invoice->property->short_name }}
								</a>
							</td>
							<td>{{ currency($invoice->total) }}</td>
							<td>{{ currency($invoice->total_balance) }}</td>
							<td>
								@if ($invoice->paid_at)
									<span class="tag is-success">
										Paid
									</span>
								@else
									<span class="tag is-warning">
										Unpaid
									</span>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			@include('partials.pagination', ['collection' => $user->invoices()->paginate()])

		</div>
	</section>

@endsection