@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Email</th>
		<th>Mobile Phone</th>
		<th>Other Phone</th>
		<th>Address</th>
	@endslot
	@slot('body')
		@foreach ($users as $user)
			<tr class="clickable-row {{ $user->isSuperAdmin() ? 'table-danger' : '' }}" data-href="{{ route('users.show', $user->id) }}" data-toggle="tooltip" data-placement="left" title="View {{ $user->present()->fullName }}'s Profile">
				<td>{{ $user->present()->fullName }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->phone_number }}</td>
				<td>{{ $user->phone_number_other }}</td>
				<td>
					@if ($user->getCurrentLocation())
						<a href="{{ route('properties.show', $user->getCurrentLocation()->id) }}">
							{{ truncate($user->getCurrentLocation()->present()->shortAddress) }}
						</a>
					@endif
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent