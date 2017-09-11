@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('tenancies.show', $tenancy->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $tenancy->name }}</h1>
				<h3>Rent payments recorded to this tenancy.</h3>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			<h4 class="text-muted">
				{{ currency($tenancy->rent_payments->sum('amount')) }} total received
			</h4>

			<table class="table table-striped table-responsive">
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
								@foreach ($payment->users as $user)
									<a href="{{ Route('users.show', $user->id) }}" class="badge badge-primary" title="{{ $user->name }}">
										{{ $user->name }}
									</a>
								@endforeach
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

			@include('partials.pagination', ['collection' => $tenancy->statements()->paginate()])

		</div>
	</section>

@endsection