@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Tenancy</th>
		<th>Starts</th>
		<th>Ends</th>
		<th>Length</th>
	@endslot
	@slot('body')
		@foreach ($agreements as $agreement)
			<tr>
				<td>{{ $agreement->present()->status }}</td>
				<td>{{ $agreement->tenancy->present()->name }}</td>
				<td>{{ $agreement->present()->startDateFormatted }}</td>
				<td>{{ $agreement->present()->endDateFormatted }}</td>
				<td>{{ $agreement->present()->lengthFormatted }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent