@component('partials.table')
	@slot('head')
		<th>Name</th>
		<th>Created On</th>
		<th>Owners</th>
	@endslot
	@foreach ($properties as $property)
		<tr>
			<td><a href="{{ route('properties.show', $property->id) }}">{{ $property->name }}</a></td>
			<td>{{ date_formatted($property->created_at) }}</td>
			<td>
				@foreach ($property->owners as $owner)
					<a href="{{ route('users.show', $owner->id) }}">
						<span class="tag is-medium @if ($owner->property_id == $property->id) is-success @else is-primary @endif">
							{{ $owner->name }}
						</span>
					</a>
				@endforeach
			</td>
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $properties])