@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('tenancies.show', $tenancy->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $tenancy->name }}</h1>
			<h2 class="subtitle">Rent amount history</h2>

			<hr />

			<table class="table is-striped is-fullwidth">
				<thead>
					<th>Start Date</th>
					<th>Amount</th>
					<th>Status</th>
					<th>Recorded By</th>
				</thead>
				<tbody>
					@foreach ($tenancy->rents as $rent)
						<tr>
							<td>

									 {{ date_formatted($rent->starts_at) }}

							</td>
							<td>{{ currency($rent->amount) }}</td>
							<td>
								@if ($rent->starts_at > \Carbon\Carbon::now())
									<span class="tag is-primary">
										Pending
									</span>
								@endif							
							</td>
							<td>
								<a href="{{ route('users.show', $rent->owner->id) }}">
									{{ $rent->owner->name }}
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

		</div>
	</section>

@endsection