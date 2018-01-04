@component('partials.table')
	@slot('header')
		<th>Due</th>
		<th>Type</th>
	@endslot
	@slot('body')
		@foreach ($reminders as $reminder)
			<tr>
				<td>{{ date_formatted($reminder->due_at) }}</td>
				<td>{{ $reminder->reminderType->name }}</td>

			</tr>
		@endforeach
	@endslot
@endcomponent