@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('invoice-groups.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-plus"></i> New Group
		</a>

		@component('partials.header')
			Invoice Groups List
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@component('partials.table')
			@slot('header')
				<th>Name</th>
				<th>Next Number</th>
				<th>Format</th>
				<th></th>
			@endslot
			@slot('body')
				@foreach ($groups as $group)
					<tr>
						<td>{{ $group->name }}</td>
						<td>{{ $group->next_number }}</td>
						<td>{{ $group->format }}</td>
						<td class="text-right">
							<a href="{{ route('invoice-groups.show', $group->id) }}" class="btn btn-primary btn-sm">
								@icon('view')
							</a>
						</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

	@endcomponent

@endsection