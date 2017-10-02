@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					{{ $title }}
					<a href="{{ route('gas-safe.create') }}" class="btn btn-primary">
						<i class="fa fa-plus"></i> New Gas Safe Reminder
					</a>
				</h1>
			</div>

			{{-- Users Search --}}
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
			{{-- End of Users Search --}}

		</div>
	</section>

	<section class="section">
		<div class="container">

			<table class="table table-striped table-responsive">
				<thead>
					<th>Expires</th>
					<th>Property</th>
					<th>Contractor</th>
					<th>Last Reminder</th>
					<th>Booked</th>
				</thead>
				<tbody>
					@foreach ($reminders as $reminder)
						<tr>
							<td>
								<a href="{{ route('gas-safe.show', $reminder->id) }}">
									{{ date_formatted($reminder->expires_on) }}
								</a>
							</td>
							<td>{{ $reminder->property->short_name }}</td>
							<td>
								@foreach ($reminder->contractors as $user)
									<a class="badge badge-primary" title="{{ $user->name }}" href="{{ route('users.show', $user->id) }}">
										{{ $user->name }}
									</a>
								@endforeach
							</td>
							<td>{{ $reminder->last_reminder ? date_formatted($reminder->last_reminder) : '-' }}</td>
							<td><i class="fa fa-{{ $reminder->is_booked ? 'check' : 'times' }}"></i></td>
						</tr>
					@endforeach
				</tbody>
			</table>

			@include('partials.pagination', ['collection' => $reminders])

		</div>
	</section>

@endsection