@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Name</th>
		<th>Property</th>
		<th>Rent</th>
		<th>Balance</th>
		<th>Service</th>
		@if (isset($daysOverdue))
			<th>Days</th>
		@endif
		<th></th>
	@endslot
	@slot('body')
		@foreach ($tenancies as $tenancy)
			<tr>
				<td>{{ $tenancy->present()->status }}</td>
				<td>{{ truncate($tenancy->present()->name) }}</td>
				<td>{{ truncate($tenancy->property->present()->shortAddress) }}</td>
				<td>{{ $tenancy->present()->rentAmount }}</td>
				<td>{{ $tenancy->present()->rentBalance }}</td>
				<td>{{ $tenancy->present()->serviceName }}</td>
				@if (isset($daysOverdue))
					<td>{{ $tenancy->is_overdue }}</td>
				@endif
				<td class="text-right">
					<a href="{{ route('tenancies.show', $tenancy->id) }}" class="btn btn-primary btn-sm">
						View
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent