@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Property</th>
		<th>Rent</th>
		<th>Balance</th>
		<th>Service</th>
		@if (isset($daysOverdue))
			<th>Days</th>
		@endif
		<th>Status</th>
	@endslot
	@slot('body')
		@foreach ($tenancies as $tenancy)
			<tr>
				<td>
					<a href="{{ route('tenancies.show', $tenancy->id) }}">
						{{ $tenancy->present()->name }}
					</a>
				</td>
				<td>{{ $tenancy->property->present()->shortAddress }}</td>
				<td>{{ $tenancy->present()->rentAmount }}</td>
				<td>{{ $tenancy->present()->rentBalance }}</td>
				<td>{{ $tenancy->present()->serviceName }}</td>
				@if (isset($daysOverdue))
					<td>{{ $tenancy->is_overdue }}</td>
				@endif
				<td>
					@include('tenancies.partials.table-status-label')
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent