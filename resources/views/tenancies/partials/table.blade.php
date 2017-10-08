@component('partials.table')
	@slot('head')
		<th>Name</th>
		<th>Property</th>
		<th>Rent</th>
		<th>Balance</th>
		<th>Service</th>
		<th>Status</th>
	@endslot
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
				@if (!is_null($tenancy->vacated_on) && ($tenancy->vacated_on <= \Carbon\Carbon::now()))
					<span class="badge badge-danger">
						Vacated
					</span>
				@endif
				@if (!is_null($tenancy->vacated_on) && ($tenancy->vacated_on > \Carbon\Carbon::now()))
					<span class="badge badge-warning">
						Vacating
					</span>
				@endif
			</td>
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $tenancies])