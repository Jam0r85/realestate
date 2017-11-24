@component('partials.table')
	@slot('header')
		<th>ID</th>
		<th>Section</th>
		<th>Status</th>
		<th>Property</th>
		<th>Visibility</th>
		<th>Live</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($appearances as $appearance)
			<tr>
				<td>{{ $appearance->id }}</td>
				<td>{{ $appearance->section->name }}</td>
				<td>{{ $appearance->present()->statusLabel }}</td>
				<td>{{ $appearance->property->present()->shortAddress }}</td>
				<td>{!! $appearance->present()->visibility !!}</td>
				<td>{{ $appearance->present()->liveStatus }}</td>
				<td class="text-right">
					<a href="{{ route('appearances.show', $appearance->id) }}" class="btn btn-primary btn-sm">
						Edit
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent