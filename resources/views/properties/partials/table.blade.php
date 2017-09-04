<table class="table table-striped table-responsive">
	<thead>
		<th>Name</th>
		<th>Owners</th>
	</thead>
	<tbody>
		@foreach ($properties as $property)
			<tr>
				<td>
					<a href="{{ route('properties.show', $property->id) }}">
						{{ $property->name }}
					</a>
				</td>
				<td>
					@foreach ($property->owners as $owner)
						<a href="{{ route('users.show', $owner->id) }}" class="badge badge-primary">
							{{ $owner->name }}
						</a>
					@endforeach
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $properties])