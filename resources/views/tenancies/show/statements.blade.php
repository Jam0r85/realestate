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
					<th>Period</th>
					<th>Amount</th>
					<th>Invoice</th>
					<th>Date</th>
					<th>Status</th>
				</thead>
				<tbody>
					@foreach ($tenancy->statements()->paginate() as $statement)
						<tr>
							<td>
								<a href="{{ route('statements.show', $statement->id) }}">
									{{ date_formatted($statement->period_start) }} - {{ date_formatted($statement->period_end) }}
								</a>
							</td>
							<td>{{ currency($statement->amount) }}</td>
							<td>
								@if ($statement->hasInvoice())
									<a href="{{ route('invoices.show', $statement->invoice->id) }}">
										{{ $statement->invoice->number }}
									</a>
								@endif
							</td>
							<td>{{ date_formatted($statement->created_at) }}</td>
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