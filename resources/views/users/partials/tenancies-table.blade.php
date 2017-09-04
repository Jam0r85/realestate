<table class="table table-striped table-responsive">
	<thead>
		<th>Started</th>
		<th>Tenancy</th>
		<th>Property</th>
		<th>Rent</th>
		<th>Balance</th>
		<th>Service</th>
	</thead>
	<tbody>
		@foreach ($user->tenancies as $tenancy)
			<tr>
				<td>{{ date_formatted($tenancy->started_at) }}</td>
				<td>
					<a href="{{ route('tenancies.show', $tenancy->id) }}" title="{{ $tenancy->name }}">
						{{ $tenancy->name }}
					</a>
				</td>
				<td>{{ $tenancy->property->short_name }}</td>
				<td>{{ $tenancy->current_rent ? currency($tenancy->current_rent->amount) : '' }}</td>
				<td>{{ currency($tenancy->rent_balance) }}</td>
				<td>{{ $tenancy->service->name }}</td>
			</tr>
		@endforeach
	</tbody>
</table>