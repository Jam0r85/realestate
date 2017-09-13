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
					<th>Tenancy</th>
					<th>Property</th>
					<th>Rent</th>
					<th>Balance</th>
					<th>Last Payment</th>
				</thead>
				<tbody>
					@foreach ($tenancies as $tenancy)
						<tr>
							<td>{{ $tenancy->days_overdue }} {{ str_plural('day', $tenancy->days_overdue) }}</td>
							<td>
								<a href="{{ route('tenancies.show', $tenancy->id) }}" title="{{ $tenancy->name }}">
									{{ $tenancy->name }}
								</a>
							</td>
							<td>{{ $tenancy->property->short_name }}</td>
							<td>{{ $tenancy->current_rent ? currency($tenancy->current_rent->amount) : 'None' }}</td>
							<td>
								<span class="@if ($tenancy->rent_balance < 0) text-danger @endif">
									{{ currency($tenancy->rent_balance) }}
								</span>
							</td>
							<td>{{ $tenancy->last_rent_payment ? date_formatted($tenancy->last_rent_payment->created_at) : 'Never' }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

		</div>
	</section>

@endsection