<table class="table table-striped table-responsive">
	<thead>
		<th>Name</th>
	</thead>
	<tbody>
		@foreach ($calendars as $calendar)
			<tr>
				<td><a href="{{ route('calendars.show', $calendar->id) }}">{{ $calendar->name }}</a></td>
			</tr>
		@endforeach
	</tbody>
</table>