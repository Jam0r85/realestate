<table class="table is-fullwidth is-striped">
	<thead>
		<th>Name</th>
		<th>Rent</th>
		<th>Started</th>
		<th>Status</th>
	</thead>
	<tbody>
		@foreach ($property->tenancies as $tenancy)
			<tr>
				<td>
					<a href="{{ route('tenancies.show', $tenancy->id) }}" title="{{ $tenancy->name }}">
						{!! truncate($tenancy->name) !!}
					</a>
				</td>
				<td>{{ currency($tenancy->rent_amount) }}</td>
				<td>{{ date_formatted($tenancy->started_at) }}</td>
				<td>{{ $tenancy->vacated_on ? 'Vacated' : 'Running' }}</td>
			</tr>
		@endforeach
	</tbody>
</table>