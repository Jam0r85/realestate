@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Amount</th>
		<th>From</th>
		<th>Tenancy</th>
	@endslot
	@slot('body')
		@foreach ($rents as $rent)
			<tr>
				<td></td>
				<td>{{ currency($rent->amount) }}</td>
				<td>{{ date_formatted($rent->starts_at) }}</td>
				<td>{{ $rent->tenancy->present()->name }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent