@component('partials.table')
	@slot('head')
		<th>Name</th>
		<th>Branch</th>
		<th></th>
	@endslot
	@foreach ($roles as $role)
		<tr>
			<td>{{ $role->name }}</td>
			<td>{{ $role->branch->name }}</td>
			<td class="has-text-right">
				<a href="{{ route('roles.show', $role->id) }}" class="button is-small is-warning">
					<span class="icon is-small">
						<i class="fa fa-edit"></i>
					</span>
					<span>
						Edit
					</span>
				</a>
			</td>
		</tr>
	@endforeach
@endcomponent