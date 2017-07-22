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
							
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Landlord Balance
						</p>
						<p class="title">
							
						</p>
					</div>
				</div>
			</nav>

		</div>
	</section>

	@component('partials.sections.section')

		<div class="columns is-flex is-column-mobile">
			<div class="column is-3">
				<aside class="menu">
					<p class="menu-label">
						Statement
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('statements.show', $statement->id) }}" class="{{ set_active(route('statements.show', $statement->id)) }}">
								Items
							</a>
							<a href="{{ route('statements.show', [$statement->id, 'new-invoice-item']) }}" class="{{ set_active(route('statements.show', [$statement->id, 'new-invoice-item'])) }}">
								Create Invoice Item
							</a>
							<a href="#">
								Create Expense Item
							</a>
							<a href="{{ route('downloads.statement', $statement->id) }}" target="_blank">
								Download
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
			<div class="column is-9">

				@yield('sub-content')

			</div>
		</div>

	@endcomponent

@endsection