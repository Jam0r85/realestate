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
			</div>

		</div>
	</section>

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $statement->name }}
		@endslot
		@slot('subTitle')
			{{ $statement->property->name }}
			@foreach ($statement->users as $user)
				<a href="{{ route('users.show', $user->id) }}">
					<span class="tag is-light">
						{{ $user->name }}
					</span>
				</a>
			@endforeach
		@endslot
	@endcomponent

	<section class="hero is-dark is-bold">
		<div class="hero-body">

			<nav class="level">
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Amount
						</p>
						<p class="title">
							{{ currency($statement->amount) }}
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Invoices Total
						</p>
						<p class="title">
							{{ currency($statement->invoice_total_amount) }}
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Expenses Total
						</p>
						<p class="title">
							{{ currency($statement->expense_total_amount) }}
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Landlord Balance
						</p>
						<p class="title">
							{{ currency($statement->landlord_balance_amount) }}
						</p>
					</div>
				</div>
			</nav>

		</div>
	</section>

	@component('partials.sections.section')

		<div class="columns is-flex is-column-mobile side-nav">
			<div class="column is-3">
				<aside class="menu">
					<p class="menu-label">
						Statement
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('statements.show', $statement->id) }}" class="{{ set_active(route('statements.show', $statement->id)) }}">
								<span class="icon is-small">
									<i class="fa fa-list"></i>
								</span>
								Statement Items
							</a>
							@if (!$statement->paid_at)
								<a href="{{ route('statements.show', [$statement->id, 'new-invoice-item']) }}" class="{{ set_active(route('statements.show', [$statement->id, 'new-invoice-item'])) }}">
									<span class="icon is-small">
										<i class="fa fa-plus"></i>
									</span>
									Create Invoice Item
								</a>
								<a href="{{ route('statements.show', [$statement->id, 'new-expense-item']) }}" class="{{ set_active(route('statements.show', [$statement->id, 'new-expense-item'])) }}">
									<span class="icon is-small">
										<i class="fa fa-plus"></i>
									</span>
									Create Expense Item
								</a>
							@endif
							<a href="{{ route('statements.show', [$statement->id, 'settings']) }}" class="{{ set_active(route('statements.show', [$statement->id, 'settings'])) }}">
									<span class="icon is-small">
										<i class="fa fa-cogs"></i>
									</span>
								Settings
							</a>
							@if ($statement->canDelete())
								<a href="{{ route('statements.show', [$statement->id, 'delete']) }}" class="{{ set_active(route('statements.show', [$statement->id, 'delete'])) }}">
									<span class="icon is-small">
										<i class="fa fa-trash"></i>
									</span>
									Delete
								</a>
							@endif
						</li>
					</ul>
					<p class="menu-label">
						Statement Actions
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('statements.show', [$statement->id, 'send']) }}" class="{{ set_active(route('statements.show', [$statement->id, 'send'])) }}">
								<span class="icon is-small">
									<i class="fa fa-envelope"></i>
								</span>
								{{ $statement->sent_at ? 'Re-Send' : 'Send' }} Statement
							</a>
							<a href="{{ route('downloads.statement', $statement->id) }}" target="_blank">
								<span class="icon is-small">
									<i class="fa fa-download"></i>
								</span>
								Download Statement
							</a>
						</li>
					</ul>
					<p class="menu-label">
						Payments
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('statements.show', [$statement->id, 'payments']) }}" class="{{ set_active(route('statements.show', [$statement->id, 'payments'])) }}">
								<span class="icon is-small">
									<i class="fa fa-gbp"></i>
								</span>
								Payments Out
							</a>
						</li>
					</ul>
					<p class="menu-label">
						Invoice
					</p>
					@if ($statement->hasInvoice())
						<ul class="menu-list">
							<li>
								<a href="{{ route('invoices.show', $statement->invoice->id) }}">
									Invoice #{{ $statement->invoice->number }}
								</a>
								<a href="{{ route('downloads.invoice', $statement->invoice->id) }}" target="_blank">
									<span class="icon is-small">
										<i class="fa fa-download"></i>
									</span>
									Download Invoice
								</a>	
							</li>
						</ul>
					@endif
				</aside>
			</div>
			<div class="column is-faded is-9">

				<section class="section">

					<div class="field is-grouped is-grouped-multiline">
						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-medium is-dark">
									Address
								</span>
								<span class="tag is-medium is-primary">
									{{ $statement->recipient_inline }}
								</span>
							</div>
						</div>
						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-medium is-dark">
									Send By
								</span>
								<span class="tag is-medium is-primary">
									@if ($statement->sendByPost())
										Post
									@else
										E-Mail
									@endif
								</span>
							</div>
						</div>
						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-medium is-dark">
									Pay By
								</span>
								<span class="tag is-medium is-primary">
									@if ($statement->bank_account)
										Bank Account
									@else
										Cash or Cheque
									@endif
								</span>
							</div>
						</div>
						<div class="control">
							<div class="tags has-addons">
								<span class="tag is-medium is-dark">
									Payments
								</span>
								<span class="tag is-medium {{ count($statement->payments) ? 'is-success' : 'is-danger' }}">
									{{ count($statement->payments) ? 'Generated' : 'Not Generated' }}
								</span>
							</div>
						</div>
					</div>

				</section>

				@yield('sub-content')

			</div>
		</div>

	@endcomponent

@endsection