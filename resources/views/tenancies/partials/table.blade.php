@component('partials.table')
	@slot('head')
		<th>Name</th>
		<th>Property</th>
		<th>Rent</th>
		<th>Balance</th>
	@endslot
	@foreach ($tenancies as $tenancy)
		<tr>
			<td><a href="{{ route('tenancies.show', $tenancy->id) }}">{{ $tenancy->name }}</a></td>
			<td>{{ $tenancy->property->short_name }}</td>
			<td>{{ currency($tenancy->rent_amount) }}</td>
			<td>{{ currency($tenancy->rent_balance) }}</td>
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $tenancies])