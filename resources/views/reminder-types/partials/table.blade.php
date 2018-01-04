@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th class="text-right">Reminders</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($types as $type)
			<tr>
				<td>
					{{ $type->name }}<br />
					{{ $type->description }}
				</td>
				<td class="text-right">{{ $type->present()->autoReminderPeriod }}</td>
				<td class="text-right">
					<a href="{{ route('reminder-types.show', $type->id) }}" class="btn btn-primary btn-sm">
						@icon('view')
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent