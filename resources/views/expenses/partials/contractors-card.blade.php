<div class="card text-white @if (count($expense->contractors)) bg-success @else bg-danger @endif mb-3">
	<div class="card-header">
		<i class="fa fa-users"></i> Contractors
	</div>

	@if (count($expense->contractors))

		<ul class="list-group list-group-flush">
			@foreach ($expense->contractors as $user)
				@component('partials.bootstrap.list-group-item')
					<a href="{{ route('users.show', $user->id) }}" title="{{ $user->name }}">
						{{ $user->name }}
					</a>
				@endcomponent
			@endforeach
		</ul>

	@else
		<div class="card-body">
			<b>No contractors linked!</b>
		</div>
	@endif

</div>