@component('partials.card')
	@slot('header')
		Property Reminders
	@endslot

	@include('reminder-types.partials.table', [
		'types' => reminder_types('properties')
	])

@endcomponent

@component('partials.card')
	@slot('header')
		Tenancy Reminders
	@endslot

	@include('reminder-types.partials.table', [
		'types' => reminder_types('tenancies')
	])

@endcomponent

<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#newPropertyReminderTypeModal">
	@icon('plus') Reminder Type
</button>

@include('settings.modals.new-property-reminder-type')