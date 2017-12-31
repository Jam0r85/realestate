@include('reminders.partials.table', [
	'reminders' => $reminders = $type->reminders()->paginate()
])

@include('partials.pagination', [
	'collection' => $reminders
])