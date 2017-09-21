<table class="table table-striped table-responsive">
	<thead>
		<th>Date</th>
		<th>Tenancy</th>
		<th>Amount</th>
		<th>Balance</th>
		<th>ID</th>
	</thead>
	<tbody>
		@foreach ($deposits as $deposit)
			<tr>
				<td>{{ date_formatted($deposit->created_at) }}</td>
				<td>
					<a href="{{ route('tenancies.show', $deposit->tenancy->id) }}" title="{{ $deposit->tenancy->name }}">
						{{ $deposit->tenancy->name }}
					</a>
				</td>
				<td>{{ currency($deposit->amount) }}</td>
				<td>
					<span class="@if ($deposit->balance < $deposit->amount) text-danger @endif">
						{{ currency($deposit->balance) }}
					</span>
				</td>
				<td>{{ $deposit->unique_id }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $deposits])