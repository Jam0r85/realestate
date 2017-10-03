@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-secondary float-right">
					Return
				</a>	
				<h1>Invoice #{{ $invoice->number }}</h1>
				<h3>Record a Payment</h3>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			<div class="row">
				<div class="col-sm-12 col-md-6">

					@include('partials.errors-block')

					<div class="card mb-3">
						<div class="card-header bg-primary text-white">
							Direct Payment
						</div>
						<div class="card-body">

							<form role="form" method="POST" action="{{ route('invoices.create-payment', $invoice->id) }}">
								{{ csrf_field() }}

								@include('invoices.partials.payment-form')

								@component('partials.bootstrap.save-submit-button')
									Record Payment
								@endcomponent

							</form>

						</div>
					</div>

				</div>
				<div class="col-sm-12 col-md-6">

					<div class="card mb-3">
						<div class="card-header">
							Invoice Details
						</div>
						<ul class="list-group list-group-flush">
							@component('partials.bootstrap.list-group-item')
								{{ currency($invoice->total) }}
								@slot('title')
									Invoice Total
								@endslot
							@endcomponent
							@component('partials.bootstrap.list-group-item')
								{{ currency($invoice->total_balance) }}
								@slot('title')
									Balance Remaining
								@endslot
							@endcomponent
						</ul>
					</div>

					<div class="card mb-3">
						<div class="card-header">
							Payments History
						</div>
						<table class="table table-striped table-responsive">
							<thead>
								<th>Date</th>
								<th>Amount</th>
								<th>Method</th>
							</thead>
							<tbody>
								@foreach ($invoice->payments as $payment)
									<tr>
										<td>{{ date_formatted($payment->created_at) }}</td>
										<td>{{ currency($payment->amount) }}</td>
										<td>{{ $payment->method->name }}</td>
									</tr>
								@endforeach
								@foreach ($invoice->statement_payments as $payment)
									<tr>
										<td>{{ date_formatted($payment->created_at) }}</td>
										<td>{{ currency($payment->amount) }}</td>
										<td>Statement #{{ $payment->statement->id }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

				</div>
			</div>

		</div>
	</section>

@endsection