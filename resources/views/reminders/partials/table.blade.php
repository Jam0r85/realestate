@component('partials.table')
	@slot('header')
		<th>Due</th>
		<th>Type</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($reminders as $reminder)
			<tr>
				<td>{{ date_formatted($reminder->due_at) }}</td>
				<td>{{ $reminder->reminderType->name }}</td>
				<td class="text-right">
					<a href="{{ route('reminders.show', $reminder->id) }}" class="btn btn-primary btn-sm">
						@icon('view')
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent