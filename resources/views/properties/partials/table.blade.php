@component('partials.table')
	@slot('head')
		<th>Name</th>
		<th>Branch Recorded</th>
		<th>Owners</th>
	@endslot
	@foreach ($properties as $property)
		<tr>
			<td><a href="{{ route('properties.show', $property->id) }}">{{ $property->name }}</a></td>
			<td>{{ $property->branch->name }}</td>
			<td>
				@foreach ($property->owners as $owner)
					<span class="tag is-primary">{{ $owner->name }}</span>
				@endforeach
			</td>
		</tr>
	@endforeach
@endcomponent