@component('partials.table')
	@slot('head')
		<th>Name</th>
		<th>E-Mail</th>
		<th>Phone Number</th>
	@endslot
	@each('branches.partials.table-row', $branches, 'branch')
@endcomponent