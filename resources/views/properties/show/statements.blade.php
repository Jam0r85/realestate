@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('properties.show', $property->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $property->name }}</h1>
			<h2 class="subtitle">Statements list</h2>

			<hr />

			<table class="table is-striped is-fullwidth">
				<thead>
					<th>Created</th>
					<th>Starts</th>
					<th>Ends</th>
					<th>Tenancy</th>
					<th>Amount</th>
					<th>Invoice</th>
					<th>Status</th>
				</thead>
				<tbody>
					@foreach ($property->statements()->paginate() as $statement)
						<tr>
							<td>
								<a href="{{ route('statements.show', $statement->id) }}">
									{{ date_formatted($statement->created_at) }}
								</a>
							</td>
							<td>{{ date_formatted($statement->period_start) }}</td>
							<td>{{ date_formatted($statement->period_end) }}</td>
							<td>{{ $statement->tenancy->name }}</td>
							<td>{{ currency($statement->amount) }}</td>
							<td>
								@if ($statement->hasInvoice())
									<a href="{{ route('invoices.show', $statement->invoice->id) }}">
										{{ $statement->invoice->number }}
									</a>
								@endif
							</td>
							<td>
								@if ($statement->sent_at)
									<span class="tag is-success">
										Sent
									</span>
								@else
									@if ($statement->paid_at)
										<span class="tag is-info">
											Paid
										</span>
									@else
										<span class="tag is-warning">
											Unpaid
										</span>
									@endif
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			@include('partials.pagination', ['collection' => $property->statements()->paginate()])

		</div>
	</section>

@endsection

