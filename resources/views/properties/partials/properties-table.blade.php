@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th class="text-right">Owners</th>
		<td></td>
	@endslot
	@slot('body')
		@foreach ($properties as $property)
			<tr>
				<td>{{ $property->present()->fullAddress }}</td>
				<td class="text-right">{!! $property->present()->ownerBadges !!}</td>
				<td class="text-right">
					<a href="{{ route('properties.show', $property->id) }}" class="btn btn-primary btn-sm">
						View
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent