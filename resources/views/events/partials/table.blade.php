@component('partials.table')
	@slot('head')
		<th>Date</th>
		<th>Title</th>
		<th>Body</th>
		<th></th>
	@endslot
	@foreach ($events as $event)
		<tr>
			<td>{{ datetime_formatted($event->start) }}</td>
			<td>{{ $event->title }}</td>
			<td>{{ $event->body }}</td>
			<td class="has-text-right">
				<a href="#" class="button is-small is-warning modal-button" data-target="{{ route('events.edit-link', $event->id) }}">
					Edit
				</a>
				<a href="{{ route('events.restore', $event->id) }}" class="button is-small is-dark">
					Restore
				</a>
			</td>
		</tr>
	@endforeach
@endcomponent