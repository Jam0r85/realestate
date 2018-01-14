@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>E-Mail</th>
		<th>Phone Number</th>
	@endslot
	@slot('body')
		@foreach ($branches as $branch)
			<tr class="clickable-row {{ $branch->deleted_at ? 'table-secondary' : '' }}" data-href="{{ route('branches.show', $branch->id) }}">
				<td>
					{{ $branch->name }}
					@if ($branch->deleted_at)
						<span class="text-muted">
							@icon('delete')
						</span>
					@endif
				</td>
				<td>{{ $branch->email }}</td>
				<td>{{ $branch->phone_number }}</td>
			</tr>
		@endforeach
	@endslot
@endcomponent