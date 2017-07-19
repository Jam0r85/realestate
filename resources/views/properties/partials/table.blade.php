@component('partials.table')
	@slot('head')
		<th>Name</th>
		<th>Owners</th>
		<th>Branch Recorded</th>
	@endslot
	@foreach ($properties as $property)
		<tr>
			<td><a href="{{ route('properties.show', $property->id) }}">{{ $property->name }}</a></td>
			<td>
				@foreach ($property->owners as $owner)
					<span class="tag is-primary">{{ $owner->name }}</span>
				@endforeach
			</td>
			<td>{{ $property->branch->name }}</td>
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $properties])