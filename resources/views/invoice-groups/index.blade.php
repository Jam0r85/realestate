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

		@if (!count($groups))
			@include('partials.alerts.no-records', ['message' => 'invoice groups'])
		@else

			@component('partials.table')
				@slot('header')
					<th>Name</th>
					<th>Next Number</th>
					<th>Format</th>
				@endslot
				@slot('body')
					@foreach ($groups as $group)
						<tr class="clickable-row {{ $group->deleted_at ? 'table-secondary text-muted' : '' }}" data-href="{{ route('invoice-groups.show', $group->id) }}">
							<td>{{ $group->name }} @if ($group->deleted_at) @icon('delete') @endif</td>
							<td>{{ $group->next_number }}</td>
							<td>{{ $group->format }}</td>
						</tr>
					@endforeach
				@endslot
			@endcomponent

		@endif

	@endcomponent

@endsection