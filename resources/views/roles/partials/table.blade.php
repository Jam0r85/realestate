@component('partials.table')
	@slot('header')
		<th>Branch</th>
		<th>Name</th>
		<th>Users</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($roles as $role)
			<tr>
				<td>{{ $role->branch->name }}</td>
				<td>{{ $role->name }}</td>
				<td>
					@foreach ($role->users as $user)
						<span class="badge badge-secondary">
							{{ $user->present()->name }}
						</span>
					@endforeach
				</td>
				<td class="text-right">
					<a href="{{ route('roles.show', $role->id) }}" class="btn btn-primary btn-sm" title="View">
						@icon('view')
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent