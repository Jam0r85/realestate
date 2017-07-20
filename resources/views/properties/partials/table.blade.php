@component('partials.table')
	@slot('head')
		<th>Name</th>
		<th>Owners</th>
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
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $properties])