@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@include('statements.partials.statement-dropdown-menu')
		</div>

		@component('partials.header')
			Statement #{{ $statement->id }}
		@endcomponent
		
	@endcomponent

	@component('partials.bootstrap.section-with-container')

			<h1 class="title">Statement #{{ $statement->id }}</h1>
			<h2><a href="{{ route('properties.show', $statement->property()->id) }}">{{ $statement->property()->name }}</a></h2>
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

					@if (count($statement->invoices))
						@foreach ($statement->invoices as $invoice)
							<a href="{{ route('invoices.show', $invoice->id) }}">
								<div class="notification is-info has-text-centered mb-2">
									Statement links to Invoice #{{ $invoice->present()->number }}
								</div>
							</a>
						@endforeach
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
								<td class="has-text-grey">Invoice Total</td>
								<td class="has-text-right">{{ currency($statement->getInvoiceTotal()) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Expenses Total</td>
								<td class="has-text-right">{{ currency($statement->getExpensesTotal()) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Total Out</td>
								<td class="has-text-right">{{ currency($statement->getTotal()) }}</td>
							</tr>
							<tr>
								<td class="has-text-grey">Balance to Landlord</td>
								<td class="has-text-right">{{ currency($statement->getLandlordAmount()) }}</td>
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

						@if ($statement->invoice())

							@include('invoices.partials.item-table', ['items' => $statement->invoice()->items])

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

						@include('statement-payments.partials.statement-payments-table', ['payments' => $statement->payments])

							<form method="POST" action="{{ route('statement-payments.store', $statement->id) }}">
								{{ csrf_field() }}

								@if ($statement->sent_at)
									<input type="hidden" name="sent_at" value="{{ $statement->sent_at }}" />
								@endif

								@component('partials.save-button')
									{{ count($statement->payments) ? 'Re-Generate' : 'Generate' }} Payments
								@endcomponent
							</form>

					</div>

				</div>
			</div>

	@endcomponent

@endsection