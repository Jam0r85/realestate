@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th class="text-right">Owners</th>
	@endslot
	@slot('body')
		@foreach ($properties as $property)
			<tr>
				<td>
					<a href="{{ route('properties.show', $property->id) }}">
						{{ $property->name }}
					</a>
				</td>
				<td class="text-right">
					@include('partials.bootstrap.users-inline', ['users' => $property->owners])
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent