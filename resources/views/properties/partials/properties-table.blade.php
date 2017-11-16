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
						{{ $property->present()->fullAddress }}
					</a>
				</td>
				<td class="text-right">{{ $property->present()->ownerNames }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent