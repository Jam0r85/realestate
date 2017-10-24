<div class="card mb-3">

	@component('partials.card-header')
		Contractors
	@endcomponent

	@if (count($gas->contractors))

		<ul class="list-group list-group-flush">

			@foreach ($gas->contractors as $user)

			<li class="list-group-item">
				<p class="lead mb-0">
					<a href="{{ route('users.show', $user->id) }}">
						{{ $user->name }}
					</a>
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