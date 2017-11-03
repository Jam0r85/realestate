@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<div class="float-right">
				<a href="{{ route('tenancies.show', [$tenancy->id, 'print-payments']) }}" title="Print Payments" class="btn btn-info" target="_blank">
					<i class="fa fa-print"></i> Print
				</a>
				<a href="{{ route('tenancies.show', $tenancy->id) }}" class="btn btn-secondary">
					Return
				</a>
			</div>

			@component('partials.header')
				{{ $tenancy->name }}
			@endcomponent

			@component('partials.sub-header')
				Rent payments received
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<table class="table table-striped table-responsive-sm">
			<thead>
				<th>Date</th>
				<th>Amount</th>
				<th>Method</th>
				<th>User(s)</th>
				<th>Receipt</th>
			</thead>
			<tbody>
				@foreach ($tenancy->rent_payments()->paginate() as $payment)
					<tr>
						<td>
							<a href="{{ Route('payments.show', $payment->id) }}">
								{{ date_formatted($payment->created_at) }}
							</a>
						</td>
						<td>{{ currency($payment->amount) }}</td>
						<td>{{ $payment->method->name }}</td>
						<td>
							@include('partials.bootstrap.users-inline', ['users' => $payment->users])
						</td>
						<td>
							<a href="{{ route('downloads.payment', $payment->id) }}" target="_blank" title="Download Receipt">
								Download
							</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		@include('partials.pagination', ['collection' => $tenancy->rent_payments()->paginate()])

	@endcomponent

@endsection