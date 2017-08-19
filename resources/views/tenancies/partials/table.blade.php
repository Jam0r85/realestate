@component('partials.table')
	@slot('head')
		<th>Name</th>
		<th>Property</th>
		<th>Rent</th>
		<th>Balance</th>
		<th>Service</th>
		<th></th>
	@endslot
	@foreach ($tenancies as $tenancy)
		<tr>
			<td><a href="{{ route('tenancies.show', $tenancy->id) }}">{{ $tenancy->name }}</a></td>
			<td>{{ $tenancy->property->short_name }}</td>
			<td>{{ currency($tenancy->rent_amount) }}</td>
			<td>{{ currency($tenancy->rent_balance) }}</td>
			<td>{{ $tenancy->service->name }}</td>
			<td>
				@if (!is_null($tenancy->vacated_on) && ($tenancy->vacated_on <= \Carbon\Carbon::now()))
					<span class="tag is-danger">
						Vacated
					</span>
				@endif
				@if (!is_null($tenancy->vacated_on) && ($tenancy->vacated_on > \Carbon\Carbon::now()))
					<span class="tag is-warning">
						Vacating
					</span>
				@endif
			</td>
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $tenancies])