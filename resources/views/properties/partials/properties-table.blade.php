@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th class="text-right">Owners</th>
	@endslot
	@slot('body')
		@foreach ($properties as $property)
			<tr class="clickable-row" data-href="{{ route('properties.show', $property->id) }}" data-toggle="tooltip" data-placement="left" title="View {{ $property->present()->shortAddress }}">
				<td>{{ $property->present()->fullAddress }}</td>
				<td class="text-right">{!! $property->present()->ownerBadges !!}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent