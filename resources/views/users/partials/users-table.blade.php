@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Email</th>
		<th>Mobile Phone</th>
		<th>Other Phone</th>
		<th>Address</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($users as $user)
			<tr>
				<td>{{ $user->present()->fullName }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->phone_number }}</td>
				<td>{{ $user->phone_number_other }}</td>
				<td>
					@if ($user->getCurrentLocation())
						<a href="{{ route('properties.show', $user->getCurrentLocation()->id) }}">
							{{ $user->getCurrentLocation()->present()->shortAddress }}
						</a>
					@endif
				</td>
				<td class="text-right">
					<a href="{{ route('users.show', $user->id) }}" class="btn btn-primary btn-sm">
						@icon('view')
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent