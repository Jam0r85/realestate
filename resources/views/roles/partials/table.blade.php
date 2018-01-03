@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Staff</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($branch->roles as $role)
			<tr>
				<td>{{ $role->name }}</td>
				<td></td>
				<td class="text-right">
					<a href="{{ route('roles.show', $role->id) }}" class="btn btn-primary btn-sm" title="View">
						@icon('view')
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent