@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('tenancies.show', $tenancy->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $tenancy->name }}</h1>
			<h2 class="subtitle">Tenancy agreement history</h2>

			<hr />

			<table class="table is-striped is-fullwidth">
				<thead>
					<th>Start Date</th>
					<th>Length</th>
					<th>End Date</th>
					<th>Status</th>
					<th>Recorded By</th>
				</thead>
				<tbody>
					@foreach ($tenancy->agreements as $agreement)
						<tr>
							<td>{{ date_formatted($agreement->starts_at) }}</td>
							<td>{{ $agreement->length_formatted }}</td>
							<td>{{ $agreement->ends_at_formatted }}</td>
							<td>{{ $agreement->getStatusFormatted() }}</td>
							<td>
								<a href="{{ route('users.show', $agreement->owner->id) }}">
									{{ $agreement->owner->name }}
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

		</div>
	</section>

@endsection