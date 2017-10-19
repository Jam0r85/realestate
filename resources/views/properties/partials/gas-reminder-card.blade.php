@if ($gas = $property->gas()->notComplete()->first())

	<div class="card mb-3 border-primary">
		<h5 class="card-header bg-primary text-white">
			<i class="fa fa-calendar"></i> Gas Safe Reminder
		</h5>
		<div class="card-body">

			<p class="card-text">
				<span class="float-right badge badge-{{ $gas->expires_on <= \Carbon\Carbon::now() ? 'danger' : 'success' }}">
					{{ $gas->expires_on <= \Carbon\Carbon::now() ? 'Expired' : 'In Date' }}
				</span>
				Expires {{ date_formatted($gas->expires_on) }}
			</p>

			<a href="{{ route('gas-safe.show', $gas->id) }}" class="btn btn-warning">
				<i class="fa fa-pencil fa-fw"></i> Edit
			</a>

		</div>
		<div class="card-header">
			<i class="fa fa-users fa-fw"></i> Contractors
		</div>
		<ul class="list-group list-group-flush">

			@foreach ($gas->contractors as $user)

			<li class="list-group-item">
				<p class="lead mb-0">
					{{ $user->name }}
				</p>
				{!! $user->email ? $user->email : '' !!}
				{!! $user->phone_number ? $user->phone_number : '' !!}
			</li>

			@endforeach

		</ul>
	</div>

@endif