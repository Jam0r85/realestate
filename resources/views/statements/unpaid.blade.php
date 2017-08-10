@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">Unpaid Statements</h1>
			<h2 class="subtitle">List of unpaid statements.</h2>

			<hr />

			@if (!count($statements))
				<div class="notification">
					We found no unpaid statements waiting to be paid.
				</div>
			@else

				<table class="table is-striped is-fullwidth">
					<thead>
						<th>Period</th>
						<th>Tenancy &amp; Property</th>
						<th>Amount</th>
						<th>Date</th>
						<th>Payments</th>
					</thead>
					<tbody>
						@foreach ($statements as $statement)
							<tr>
								<td><a href="{{ route('statements.show', $statement->id) }}">{{ date_formatted($statement->period_start) }} - {{ date_formatted($statement->period_end) }}</a></td>
								<td>
									{{ $statement->tenancy->name }}
									<br />
									<a href="{{ route('properties.show', $statement->property->id) }}">
										<span class="tag is-light">
											{{ $statement->property->short_name }}
										</span>
									</a>
								</td>
								<td>{{ currency($statement->amount) }}</td>
								<td>{{ date_formatted($statement->created_at) }}</td>
								<td>{!! count($statement->payments) ? '<span class="tag is-success">Generated</span>' : '<span class="tag is-danger">Not Generated</span>' !!}</td>
							</tr>
						@endforeach
					</tbody>
				</table>

			@endif

		</div>
	</section>

@endsection