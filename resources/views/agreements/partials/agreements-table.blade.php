@component('partials.table')
	@slot('header')
		<th>Status</th>
		@if (!isset($tenancy))
			<th>Tenancy</th>
		@endif
		<th>Starts</th>
		<th>Ends</th>
		<th>Length</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($agreements as $agreement)
			<tr>
				<td>{{ $agreement->present()->status }}</td>
				@if (!isset($tenancy))
					<td>{{ $agreement->tenancy->present()->name }}</td>
				@endif
				<td>{{ $agreement->present()->startDateFormatted }}</td>
				<td>{{ $agreement->present()->endDateFormatted }}</td>
				<td>{{ $agreement->present()->lengthFormatted }}</td>
				<td class="text-right">
					<a href="{{ route('agreements.edit', $agreement->id) }}" class="btn btn-warning btn-sm">
						@icon('edit')
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent