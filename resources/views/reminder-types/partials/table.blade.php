@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Description</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($types as $type)
			<tr>
				<td>{{ $type->name }}</td>
				<td>{{ $type->description }}</td>
				<td class="text-right">
					<a href="{{ route('reminder-types.show', $type->id) }}" class="btn btn-secondary btn-sm">
						View
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent