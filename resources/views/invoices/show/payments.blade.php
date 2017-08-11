@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('invoices.show', $invoice->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">Invoice #{{ $invoice->number }}</h1>
			<h2 class="subtitle">Record a Payment</h2>

			<hr />

			@include('partials.errors-block')

			<div class="columns">
				<div class="column is-4">

					<div class="card">
						<header class="card-header">
							<p class="card-header-title">Record a Payment</p>
						</header>
						<div class="card-content">

							<form role="form" method="POST" action="{{ route('invoices.create-payment', $invoice->id) }}">
								{{ csrf_field() }}

								@include('invoices.partials.payment-form')

								<button type="submit" class="button is-primary">
									<span class="icon is-small">
										<i class="fa fa-save"></i>
									</span>
									<span>
										Record Payment
									</span>
								</button>

							</form>

						</div>
					</div>

				</div>
				<div class="column is-8">

					<div class="card">
						<div class="card-content">

							<h3 class="title">Payments History</h3>
							<h5 class="subtitle">List of payments made towards this invoice.</h5>

							<table class="table is-striped is-fullwidth">
								<thead>
									<th>Date</th>
									<th>Amount</th>
									<th>Method</th>
									<th>Users</th>
								</thead>
								<tbody>
									@foreach ($invoice->payments as $payment)
										<tr>
											<td>{{ date_formatted($payment->created_at) }}</td>
											<td>{{ currency($payment->amount) }}</td>
											<td>{{ $payment->method->name }}</td>
											<td>
												@foreach ($payment->users as $user)
													<span class="tag is-primary">
														{{ $user->name }}
													</span>
												@endforeach
											</td>
										</tr>
									@endforeach
									@foreach ($invoice->statement_payments as $payment)
										<tr>
											<td>{{ date_formatted($payment->created_at) }}</td>
											<td>{{ currency($payment->amount) }}</td>
											<td>Statement #{{ $payment->statement->id }}</td>
											<td>
												@foreach ($payment->users as $user)
													<span class="tag is-primary">
														{{ $user->name }}
													</span>
												@endforeach
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>

						</div>
					</div>

				</div>
			</div>

		</div>
	</section>

@endsection