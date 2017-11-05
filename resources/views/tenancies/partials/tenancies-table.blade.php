@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Property</th>
		<th>Rent</th>
		<th>Balance</th>
		<th>Service</th>
		<th>Status</th>
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
				<td>{{ currency($tenancy->rent_amount) }}</td>
				<td>
					@include('tenancies.format.rent-balance')
				</td>
				<td>{{ $tenancy->service->name }}</td>
				<td>
					@include('tenancies.partials.table-status-label')
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent