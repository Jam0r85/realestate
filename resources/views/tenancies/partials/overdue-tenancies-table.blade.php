@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Property</th>
		<th>Rent</th>
		<th>Balance</th>
		<th>Next Statement Due</th>
	@endslot
	@slot('body')
		@foreach ($tenancies as $tenancy)
			<tr>
				<td>
					<a href="{{ route('tenancies.show', $tenancy->id) }}">
						{{ $tenancy->present()->name }}
					</a>
				</td>
				<td>{{ $tenancy->present()->propertyAddress }}</td>
				<td>{{ currency($tenancy->present()->rentAmount) }}</td>
				<td>{{ currency($tenancy->present()->rentBalance) }}</td>
				<td>{{ date_formatted($tenancy->nextStatementDate()) }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent