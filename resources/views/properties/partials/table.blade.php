@component('partials.table')
	@slot('head')
		<th>Name</th>
		<th>Owners</th>
		<th>Recorded</th>
		<th>Recorded By</th>
	@endslot
	@foreach ($properties as $property)
		<tr>
			<td><a href="{{ route('properties.show', $property->id) }}">{{ $property->name }}</a></td>
			<td>
				@foreach ($property->owners as $owner)
					<a href="{{ route('users.show', $owner->id) }}">
						<span class="tag is-primary">
							{{ $owner->name }}
						</span>
					</a>
				@endforeach
			</td>
			<td>{{ $property->branch->name }}</td>
			<td>{{ $property->owner->name }}</td>
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $properties])