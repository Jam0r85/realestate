@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<div class="float-right">
				@include('statements.partials.statement-dropdown-menu')
			</div>

			@component('partials.header')
				Statement #{{ $statement->id }}
			@endcomponent

		</div>
		
	@endcomponent

	<section class="section">
		<div class="container">

			@includeWhen($statement->canBeSent(), 'partials.alerts.primary', ['slot' => 'This statement has been paid and can be sent to the landlords.'])

			<h1 class="title">Statement #{{ $statement->id }}</h1>
			<h2><a href="{{ route('properties.show', $statement->property->id) }}">{{ $statement->property->name }}</a></h2>
			<h2 class="subtitle"><a href="{{ route('tenancies.show', $statement->tenancy->id) }}">{{ $statement->tenancy->name }}</a></h2>

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

					@if ($statement->invoice)
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
								<td>Amount Paid</td>
								<td>{{ currency($statement->payments->sum('amount')) }}</td>
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

					<div class="card mb-3">

						@component('partials.card-header')
							Invoice Items
						@endcomponent

						@if ($statement->invoice)

							@include('invoices.partials.item-table', ['items' => $statement->invoice->items])

						@else

							@component('partials.alerts.primary')
								This statement has no invoice items.
								@slot('style')
									m-0 border-0 rounded-0
								@endslot
							@endcomponent

						@endif

					</div>

					<div class="card mb-3">

						@component('partials.card-header')
							Expense Items
						@endcomponent

						@if (count($statement->expenses))

							<table class="table is-striped is-fullwidth">
								<thead>
									<th>Name</th>
									<th>Contractor</th>
									<th>Expense Cost</th>
									<th>Amount</th>
								</thead>
								<tbody>
									@foreach ($statement->expenses as $expense)
										<tr>
											<td>{{ $expense->name }}</td>
											<td>{{ $expense->contractor ? $expense->contractor->name : '' }}</td>
											<td>{{ currency($expense->cost) }}</td>
											<td>{{ currency($expense->pivot->amount) }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						@else

							@component('partials.alerts.primary')
								This statement has no expense items attached to it.
								@slot('style')
									m-0 border-0 rounded-0
								@endslot
							@endcomponent

						@endif

						<footer class="card-footer">
							<a class="card-footer-item" href="{{ route('statements.show', [$statement->id, 'new-expense-item']) }}">New Expense Item</a>
						</footer>
					</div>

					<div class="card mb-3">

						@component('partials.card-header')
							Statement Payments
						@endcomponent

							@component('partials.table')
								@slot('header')
									<th>Status</th>
									<th>Name</th>
									<th>Amount</th>
									<th>Method</th>
									<th>Recipients</th>
								@endslot
								@slot('body')
									@foreach ($statement->payments()->with('bank_account')->get() as $payment)
										<tr>
											<td>{{ $payment->present()->status }}</td>
											<td>{{ $payment->present()->name }}</td>
											<td>{{ $payment->amount }}</td>
											<td>{{ $payment->present()->method }}</td>
											<td>{{ $payment->present()->recipientNames }}</td>
										</tr>
									@endforeach
								@endslot
							@endcomponent

						<footer class="card-footer">
							<a class="card-footer-item" href="javascript:document.getElementById('generatePaymentsForm').submit();">{{ count($statement->payments) ? 'Re-Generate' : 'Generate' }} Payments</a>
							<form id="generatePaymentsForm" role="form" method="POST" action="{{ route('statements.create-payments', $statement->id) }}" style="display: hidden;">
								{{ csrf_field() }}
							</form>
							@if (count($statement->payments))
								<a class="card-footer-item" href="{{ route('statements.show', [$statement->id, 'delete-payments']) }}">Delete Payments</a>
							@endif
						</footer>
					</div>

				</div>
			</div>

		</div>
	</section>

@endsection