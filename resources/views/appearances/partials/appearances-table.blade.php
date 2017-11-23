@component('partials.table')
	@slot('header')
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
				<td>{{ $appearance->section->name }}</td>
				<td>{{ $appearance->status->name }}</td>
				<td>{{ $appearance->property->present()->shortAddress }}</td>
				<td>{!! $appearance->present()->visibility !!}</td>
				<td>{{ $appearance->present()->liveStatus }}</td>
				<td></td>
			</tr>
		@endforeach
	@endslot
@endcomponent