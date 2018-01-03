@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Name</th>
		<th>Property</th>
		<th>Tenancy</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($issues as $issue)
			<tr>
				<td>{{ $issue->present()->status }}</td>
				<td>{{ $issue->name }}</td>
				<td>{{ truncate($issue->property->present()->shortAddress) }}</td>
				<td>{{ $issue->tenancy ? truncate($issue->tenancy->present()->name) : '' }}</td>
				<td class="text-right">
					<a href="{{ route('maintenances.show', $issue->id) }}" class="btn btn-primary btn-sm">
						@icon('view')
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent