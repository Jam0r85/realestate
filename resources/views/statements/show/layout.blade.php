@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('statements.index') }}">Statements</a></li>
	<li><a href="{{ route('properties.show', $statement->property->id) }}">{{ $statement->property->short_name }}</a></li>
	<li><a href="{{ route('tenancies.show', $statement->tenancy_id) }}">{{ $statement->tenancy->name }}</a></li>
	<li class="is-active"><a>{{ $statement->name }}</a></li>
@endsection

@section('content')

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
								Payments List
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
					<div class="container">

						<div class="field is-grouped is-grouped-multiline">
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
						</div>

					</div>
				</section>

				@yield('sub-content')

			</div>
		</div>

	@endcomponent

@endsection