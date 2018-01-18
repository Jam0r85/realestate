@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Name</th>
		<th>Property</th>
		<th>Rent</th>
		<th>Balance</th>
		<th>Service</th>
		@if (request('overdue'))
			<th>Days</th>
		@endif
	@endslot
	@slot('body')
		@foreach ($tenancies as $tenancy)
			@can('show', $tenancy)
				<tr class="clickable-row" data-href="{{ route('tenancies.show', $tenancy->id) }}" data-toggle="tooltip" data-placement="left" title="View Tenancy {{ $tenancy->id }}">
					<td>{{ $tenancy->present()->status }}</td>
					<td>{{ truncate($tenancy->present()->name) }}</td>
					<td>{{ truncate($tenancy->property->present()->shortAddress) }}</td>
					<td>{{ $tenancy->present()->rentAmount }}</td>
					<td>{!! $tenancy->present()->rentBalanceFormatted !!}</td>
					<td>{{ $tenancy->present()->serviceName }}</td>
					@if (request('overdue'))
						<td>{{ $tenancy->is_overdue }}</td>
					@endif
				</tr>
			@endcan
		@endforeach
	@endslot
@endcomponent