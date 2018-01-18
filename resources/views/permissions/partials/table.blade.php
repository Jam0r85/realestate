@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Description</th>
		<th class="text-right">Slug</th>
	@endslot
	@slot('body')
		@foreach ($permissions as $permission)
			<tr class="clickable-row" data-href="{{ route('permissions.edit', $permission->id) }}" data-toggle="tooltop" data-placement="left" title="Edit Permission">
				<td>{{ $permission->name }}</td>
				<td>{{ $permission->description }}</td>
				<td class="text-right">{{ $permission->slug }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent