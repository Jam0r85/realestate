@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Permissions</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($branch->roles as $role)
			<tr>
				<td>{{ $role->name }}</td>
				<td></td>
				<td class="text-right">
					<a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm" title="Edit">
						@icon('edit')
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent