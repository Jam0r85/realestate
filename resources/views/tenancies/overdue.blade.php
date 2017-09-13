@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>Overdue Tenancies</h1>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			<table class="table table-striped table-responsive">
				<thead>
					<th>Overdue</th>
					<th>Property</th>
					<th>Tenancy</th>
					<th>Last Payment</th>
				</thead>
				<tbody>
					@foreach ($tenancies as $tenancy)
						<tr>
							<td>{{ $tenancy->days_overdue }} {{ str_plural('day', $tenancy->days_overdue) }}</td>
							<td>{{ $tenancy->property->short_name }}</td>
							<td>
								<a href="{{ route('tenancies.show', $tenancy->id) }}" title="{{ $tenancy->name }}">
									{{ $tenancy->name }}
								</a>
							</td>
							<td>{{ $tenancy->last_rent_payment ? date_formatted($tenancy->last_rent_payment->created_at) : '' }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

		</div>
	</section>

@endsection