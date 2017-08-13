@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">Statement #{{ $statement->id }}</h1>
			<h2 class="subtitle">{{ $statement->tenancy->property->name }}</h2>

			<div class="control">
				<a href="{{ route('statements.show', [$statement->id, 'edit-users']) }}" class="button is-warning">
					<span class="icon is-small">
						<i class="fa fa-edit"></i>
					</span>
					<span>
						Edit Users
					</span>
				</a>
				@foreach ($statement->users as $user)
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

					@if ($statement->hasInvoice())
						<a href="{{ route('invoices.show', $statement->invoice->id) }}">
							<div class="notification is-info has-text-centered mb-2">
								Statement links to Invoice #{{ $statement->invoice->number }}
							</div>
						</a>
					@endif

					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								Statement Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="has-text-grey">Date From</td>
								<td class="has-text-right">{{ date_formatted($statement->period_start) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Date Until</td>
								<td class="has-text-right">{{ date_formatted($statement->period_end) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Amount</td>
								<td class="has-text-right">{{ currency($statement->amount) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Invoices Total</td>
								<td class="has-text-right">{{ currency($statement->invoice_total_amount) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Expenses Total</td>
								<td class="has-text-right">{{ currency($statement->expense_total_amount) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Total Out</td>
								<td class="has-text-right">{{ currency($statement->total_amount) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Balance to Landlord</td>
								<td class="has-text-right">{{ currency($statement->landlord_balance_amount) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Date Paid</td>
								<td class="has-text-right">
									@if (is_null($statement->paid_at))
										<span class="tag is-danger">Unpaid</span>
									@else
										{{ date_formatted($statement->paid_at) }}
									@endif
								</td>
							</tr>
							<tr>
								<td class="has-text-grey">Date Sent</td>
								<td class="has-text-right">
									@if (is_null($statement->sent_at))
										<span class="tag is-danger">Unsent</span>
									@else
										{{ date_formatted($statement->sent_at) }}
									@endif
								</td>
							</tr>
						</table>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('statements.show', [$statement->id, 'edit-details']) }}">
								Edit
							</a>
							<a class="card-footer-item" href="{{ route('downloads.statement', $statement->id) }}" target="_blank">
								Download
							</a>
							<a class="card-footer-item" href="{{ route('statements.show', [$statement->id, 'send']) }}">Send</a>
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
								<td class="has-text-right">{{ date_formatted($statement->created_at) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Last Updated On</td>
								<td class="has-text-right">{{ datetime_formatted($statement->updated_at) }}</td>
							</tr>
						</table>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('statements.show', [$statement->id, 'archive']) }}">{{ $statement->trashed() ? 'Restore' : 'Archive' }} Statement</a>
						</footer>
					</div>

				</div>
				<div class="column is-8">

					<div class="card mb-2">
						<div class="card-content">

							<h3 class="title">Invoice Items</h3>
							<h5 class="subtitle">The invoice items which have been added to this statement.</h5>

							@if ($statement->hasInvoice())
								@include('invoices.partials.item-table', ['items' => $statement->invoice->items])
							@else
								<div class="notification">
									This statement has no invoice items.
								</div>
							@endif

						</div>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('statements.show', [$statement->id, 'new-invoice-item']) }}">New Invoice Item</a>
						</footer>
					</div>

					<div class="card mb-2">
						<div class="card-content">

							<h3 class="title">Expense Items</h3>
							<h5 class="subtitle">The expense items which have been added to this statement.</h5>

							@if (count($statement->expenses))
								@include('expenses.partials.table', ['expenses' => $statement->expenses])
							@else
								<div class="notification">
									This statement has no expense items.
								</div>
							@endif

						</div>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('statements.show', [$statement->id, 'new-expense-item']) }}">New Expense Item</a>
						</footer>
					</div>

					<div class="card mb-2">
						<div class="card-content">

							<h3 class="title">Statement Payments</h3>
							<h5 class="subtitle">List of individual payments to each of the statement recipients.</h5>

							@if (count($statement->payments))
								@include('expenses.partials.item-table', ['expenses' => $statement->expenses])
							@else
								<div class="notification">
									This statement has no payments generated.
								</div>
							@endif

						</div>
						<footer class="card-footer">
							<a class="card-footer-item" href="#">{{ count($statement->payments) ? 'Re-Generate' : 'Generate' }} Payments</a>
							@if (count($statement->payments))
								<a class="card-footer-item" href="#">Delete Payments</a>
							@endif
						</footer>
					</div>

				</div>
			</div>

		</div>
	</section>

@endsection