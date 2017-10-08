<table class="table table-striped table-responsive">
	<thead>
		<th>Created</th>
		<th>Starts</th>
		<th>Ends</th>
		<th>Amount</th>
		<th>Invoice</th>
		<th>Status</th>
	</thead>
	<tbody>
		@foreach ($tenancy->statements()->limit(10)->get() as $statement)
			<tr>
				<td>{{ date_formatted($statement->created_at) }}</td>
				<td>
					<a href="{{ Route('statements.show', $statement->id) }}" title="Statement #{{ $statement->id }}">
						{{ date_formatted($statement->period_start) }}
					</a>
				</td>
				<td>{{ date_formatted($statement->period_end) }}</td>
				<td>{{ currency($statement->amount) }}</td>
				<td>
					@if ($statement->invoice)
						<a href="{{ route('invoices.show', $statement->invoice->id) }}" title="Invoice #{{ $statement->invoice->number }}">
							{{ $statement->invoice->number }}
						</a>
					@endif
				</td>
				<td>
					@include('statements.format.status')
				</td>
			</tr>
		@endforeach
	</tbody>
</table>