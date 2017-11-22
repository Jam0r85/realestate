@component('partials.table')
	@slot('header')
		<th>Status</th>
		@if (!isset($tenancy))
			<th>Tenancy</th>
		@endif
		<th>Amount</th>
		<th>Date From</th>
		<th>Recorded By</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($rents as $rent)
			<tr>
				<td>{{ $rent->present()->status }}</td>
				@if (!isset($tenancy))
					<td>
						<a href="{{ route('tenancies.show', $rent->tenancy_id) }}">
							{{ $rent->tenancy->present()->name }}
						</a>
					</td>
				@endif
				<td>{{ currency($rent->amount) }}</td>
				<td>{{ date_formatted($rent->starts_at) }}</td>
				<td>{{ $rent->owner->present()->fullName }}</td>
				<td class="text-right">

				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent