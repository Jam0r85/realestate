@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('tenancies.show', $tenancy->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $tenancy->name }}</h1>
			<h2 class="subtitle">Rent payments recorded to this tenancy.</h2>

			<hr />

			<h2 class="title is-muted">
				{{ currency($tenancy->rent_payments->sum('amount')) }} total received
			</h2>

			<table class="table is-striped is-fullwidth">
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
									<a href="{{ Route('users.show', $user->id) }}">
										<span class="tag is-primary">
											{{ $user->name }}
										</span>
									</a>
								@endforeach
							</td>
							<td>
								<a href="{{ route('downloads.payment', $payment->id) }}" target="_blank">
									View
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