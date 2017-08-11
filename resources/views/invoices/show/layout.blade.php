@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">Invoice #{{ $invoice->number }}</h1>
			<h2 class="subtitle">{{ $invoice->property->name }}</h2>

			<div class="control">
				<a href="{{ route('invoices.show', [$invoice->id, 'edit-users']) }}" class="button is-warning">
					<span class="icon is-small">
						<i class="fa fa-edit"></i>
					</span>
					<span>
						Edit Users
					</span>
				</a>
				@foreach ($invoice->users as $user)
					<a href="{{ route('users.show', $user->id) }}">
						<span class="tag is-medium is-primary">
							{{ $user->name }}
						</span>
					</a>
				@endforeach
			</div>

			<hr />

			<div class="columns">
				<div class="column is-4">

					@if ($invoice->hasStatement())
						<a href="{{ route('statements.show', $invoice->statement->id) }}">
							<div class="notification is-info has-text-centered mb-2">
								Invoice links to Statement #{{ $invoice->statement->id }}
							</div>
						</a>
					@endif

					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								Invoice Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="has-text-grey">Total</td>
								<td class="has-text-right">{{ currency($invoice->total) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Net Amount</td>
								<td class="has-text-right">{{ currency($invoice->total_net) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Tax Amount</td>
								<td class="has-text-right">{{ currency($invoice->total_tax) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Payments Amount</td>
								<td class="has-text-right">{{ currency($invoice->total_payments) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Remaining Balance</td>
								<td class="has-text-right">{{ currency($invoice->total_balance) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Payment Due</td>
								<td class="has-text-right">{{ date_formatted($invoice->due_at) }}</td>
							</tr>
						</table>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('invoices.show', [$invoice->id, 'edit-details']) }}">Edit Details</a>
							<a class="card-footer-item" href="{{ route('downloads.invoice', $invoice->id) }}" target="_blank">Download</a>
							<a class="card-footer-item" href="#">Send</a>
						</footer>
					</div>

					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								System Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="has-text-grey">Created On</td>
								<td class="has-text-right">{{ date_formatted($invoice->created_at) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Last Updated On</td>
								<td class="has-text-right">{{ datetime_formatted($invoice->updated_at) }}</td>
							</tr>
						</table>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('invoices.show', [$invoice->id, 'archive']) }}">Archive Invoice</a>
						</footer>
					</div>

				</div>
				<div class="column is-8">

					<div class="card mb-2">
						<div class="card-content">

							<h3 class="title">Invoice Items</h3>
							<h5 class="subtitle">The items which have been added to this invoice.</h5>

							@include('invoices.partials.item-table', ['items' => $invoice->items])

						</div>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('invoices.show', [$invoice->id, 'new-item']) }}">New Item</a>
						</footer>
					</div>

					<div class="card mb-2">
						<div class="card-content">

							<h3 class="title">Payments</h3>
							<h5 class="subtitle">List of payments which have been recorded against this invoice.</h5>

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
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('invoices.show', [$invoice->id, 'record-payment']) }}">Record Payment</a>
						</footer>
					</div>

				</div>
			</div>

		</div>
	</section>

@endsection