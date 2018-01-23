@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Name</th>
		<th>Property</th>
		<th>Tenancy</th>
	@endslot
	@slot('body')
		@foreach ($issues as $issue)
			<tr class="clickable-row" data-href="{{ route('maintenances.show', $issue->id) }}" data-toggle="tooltip" data-placement="left" title="View {{ $issue->name }}">
				<td>{{ $issue->present()->statusLabel }}</td>
				<td>{{ $issue->name }}</td>
				<td>{{ truncate($issue->property->present()->shortAddress) }}</td>
				<td>{{ $issue->tenancy ? truncate($issue->tenancy->present()->name) : '' }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent