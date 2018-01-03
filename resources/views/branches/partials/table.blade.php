@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>E-Mail</th>
		<th>Phone Number</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($branches as $branch)
			<tr>
				<td>{{ $branch->name }}</td>
				<td>{{ $branch->email }}</td>
				<td>{{ $branch->phone_number }}</td>
				<td class="text-right">
					<a href="{{ route('branches.show', $branch->id) }}" class="btn btn-primary btn-sm">
						@icon('view')
					</a>
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent