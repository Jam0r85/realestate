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
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Send By
						</p>
						<p class="title">
							@if ($statement->sendByPost())
								By Post
							@else
								By E-Mail
							@endif
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
								Items
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
								{{ $statement->sent_at ? 'Re-Send' : 'Send' }}
							</a>
							<a href="{{ route('downloads.statement', $statement->id) }}" target="_blank">
								<span class="icon is-small">
									<i class="fa fa-download"></i>
								</span>
								Download
							</a>
						</li>
					</ul>
					<p class="menu-label">
						Payments
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('statements.show', [$statement->id, 'payments']) }}" class="{{ set_active(route('statements.show', [$statement->id, 'payments'])) }}">
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
									Download
								</a>	
							</li>
						</ul>
					@endif
				</aside>
			</div>
			<div class="column is-faded is-9">

				@yield('sub-content')

			</div>
		</div>

	@endcomponent

@endsection