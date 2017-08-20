@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('properties.show', $property->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $property->name }}</h1>
			<h2 class="subtitle">Invoices list</h2>

			<hr />

			<table class="table is-striped is-fullwidth">
				<thead>
					<th>Created</th>
					<th>Number</th>
					<th>Net</th>
					<th>Tax</th>
					<th>Total</th>
					<th>Balance</th>
					<th>Users</th>
				</thead>
				<tbody>
					@foreach ($property->invoices()->paginate() as $invoice)
						<tr>
							<td>{{ date_formatted($invoice->created_at) }}</td>
							<td>
								<a href="{{ route('invoices.show', $invoice->id) }}">
									{{ $invoice->number }}
								</a>
							</td>
							<td>{{ currency($invoice->total_net) }}</td>
							<td>{{ currency($invoice->total_tax) }}</td>
							<td>{{ currency($invoice->total) }}</td>
							<td>{{ currency($invoice->total_balance) }}</td>
							<td>
								@foreach ($invoice->users as $user)
									<a href="{{ route('users.show', $user->id) }}">
										<span class="tag is-primary">
											{{ $user->name }}
										</span>
									</a>
								@endforeach
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			@include('partials.pagination', ['collection' => $property->statements()->paginate()])

		</div>
	</section>

@endsection

