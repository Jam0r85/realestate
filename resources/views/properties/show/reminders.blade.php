@include('reminders.partials.table', [
	'reminders' => $reminders = $property->reminders()->latest()->paginate()
])

@include('partials.pagination', [
	'collection' => $reminders
])