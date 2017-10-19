<div class="card mb-3">
	<h5 class="card-header">
		<i class="fa fa-users"></i> Contractors Card
	</h5>

	@if (count($reminder->contractors))

		<ul class="list-group list-group-flush">

			@foreach ($reminder->contractors as $user)

			<li class="list-group-item">
				<p class="lead mb-0">
					{{ $user->name }}
				</p>
				{!! $user->email ? $user->email : '' !!}
				{!! $user->phone_number ? $user->phone_number : '' !!}
			</li>

			@endforeach

		</ul>

	@else

		<div class="card-body">
			<p class="card-text">
				No contractors have been assigned to this gas safe reminder.
			</p>
		</div>

	@endif

</div>