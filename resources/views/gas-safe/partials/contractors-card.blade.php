<div class="card mb-3">

	@component('partials.card-header')
		Contractors
	@endcomponent

	@if (count($gas->contractors))

		@include('partials.bootstrap.users-list-group', ['users' => $gas->contractors])

	@else

		<div class="card-body">
			<p class="card-text">
				No contractors have been assigned to this gas safe reminder.
			</p>
		</div>

	@endif

</div>