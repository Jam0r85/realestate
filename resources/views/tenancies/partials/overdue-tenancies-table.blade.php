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
					<a href="{{ route('tenancies.show', $tenancy->id) }}" title="{{ $tenancy->name }}">
						{!! truncate($tenancy->name) !!}
					</a>
				</td>
				<td>{!! truncate($tenancy->property->short_name) !!}</td>
				<td>{{ currency($tenancy->getCurrentRentAmount()) }}</td>
				<td>
					@include('tenancies.format.rent-balance')
				</td>
				<td>{{ $tenancy->nextStatementDate() }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent