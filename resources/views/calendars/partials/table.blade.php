<table class="table table-striped table-responsive">
	<thead>
		<th>Name</th>
		<th>Events</th>
		<th>Archived Events</th>
		<th>Access</th>
	</thead>
	<tbody>
		@foreach ($calendars as $calendar)
			<tr>
				<td>
					<a href="{{ route('calendars.show', $calendar->id) }}" title="{{ $calendar->name }}">
						{{ $calendar->name }}
					</a>
				</td>
				<td>{{ $calendar->events->count() }}</td>
				<td>{{ $calendar->archivedEvents->count() }}</td>
				<td></td>
			</tr>
		@endforeach
	</tbody>
</table>