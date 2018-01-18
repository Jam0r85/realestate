@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Slug</th>
		<th>Description</th>
	@endslot
	@slot('body')
		@foreach ($permissions as $permission)
			<tr class="clickable-row" data-href="{{ route('permissions.edit', $permission->id) }}" data-toggle="tooltop" data-placement="left" title="Edit Permission">
				<td>{{ $permission->name }}</td>
				<td>{{ $permission->slug }}</td>
				<td>{{ $permission->description }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent