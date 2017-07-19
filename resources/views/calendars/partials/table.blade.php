@component('partials.table')
	@slot('head')
		<th>Name</th>
	@endslot
	@each('calendars.partials.table-row', $calendars, 'calendar')
@endcomponent