<table class="table table-striped table-responsive">
	<thead>
		<th>Name</th>
	</thead>
	<tbody>
		@foreach ($account->properties as $property)
			<tr>
				<td><a href="{{ route('properties.show', $property->id) }}">{{ $property->name }}</a></td>
			</tr>
		@endforeach
	</tbody>
</table>