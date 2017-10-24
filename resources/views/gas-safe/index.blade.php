@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<a href="{{ route('gas-safe.create') }}" class="btn btn-primary float-right">
				<i class="fa fa-plus"></i> New Gas Safe Inspection
			</a>
			@component('partials.title')
				{{ $title }}
			@endcomponent
		</div>

		{{-- Gas Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('gas-safe.search') }}
			@endslot
			@if (session('gas_search_term'))
				@slot('search_term')
					{{ session('gas_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Gas Search --}}

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<table class="table table-striped table-hover table-responsive">
			<thead>
				<th>Expires</th>
				<th>Property</th>
				<th>Contractor</th>
				<th>Last Reminder</th>
				<th>Booked</th>
				<th>Completed</th>
			</thead>
			<tbody>
				@foreach ($records as $gas)
					<tr class="@if (!$gas->is_completed && $gas->expires_on <= \Carbon\Carbon::now()) table-danger @endif">
						<td>
							<a href="{{ route('gas-safe.show', $gas->id) }}">
								{{ date_formatted($gas->expires_on) }}
							</a>
						</td>
						<td>{!! truncate($gas->property->short_name) !!}</td>
						<td>{{ implode(', ', $gas->contractors->pluck('name')->toArray()) }}</td>
						<td>
							@if ($reminder = $gas->reminders()->first())
								{{ date_formatted($reminder->created_at) }}
							@else
								-
							@endif							
						</td>
						<td><i class="fa fa-{{ $gas->is_booked ? 'check' : 'times' }}"></i></td>
						<td><i class="fa fa-{{ $gas->is_completed ? 'check' : 'times' }}"></i></td>
					</tr>
				@endforeach
			</tbody>
		</table>

		@include('partials.pagination', ['collection' => $records])

	@endcomponent

@endsection