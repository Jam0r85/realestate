@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('tenancies.show', $tenancy->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $tenancy->name }}</h1>
			<h2 class="subtitle">Statements list</h2>

			<hr />

			<table class="table is-striped is-fullwidth">
				<thead>
					<th>Date</th>
					<th>Start</th>
					<th>End</th>
					<th>Amount</th>
					<th>Landlord</th>
					<th>Invoice</th>
					<th>Status</th>
				</thead>
				<tbody>
					@foreach ($tenancy->statements()->paginate() as $statement)
						<tr>
							<td>
								<a href="{{ route('statements.show', $statement->id) }}">
									 {{ date_formatted($statement->created_at) }}
								</a>
							</td>
							<td>{{ date_formatted($statement->period_start) }}</td>
							<td>{{ date_formatted($statement->period_end) }}</td>
							<td>{{ currency($statement->amount) }}</td>
							<td>{{ currency($statement->landlord_balance_amount) }}</td>
							<td>
								@if ($statement->hasInvoice())
									<a href="{{ route('invoices.show', $statement->invoice->id) }}">
										{{ $statement->invoice->number }}
									</a>
								@endif
							</td>
							<td>
								@if ($statement->sent_at)
									Sent {{ date_formatted($statement->sent_at) }}
								@else
									@if ($statement->paid_at)
										Paid
									@else
										Unpaid
									@endif
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			@include('partials.pagination', ['collection' => $tenancy->statements()->paginate()])

		</div>
	</section>

@endsection