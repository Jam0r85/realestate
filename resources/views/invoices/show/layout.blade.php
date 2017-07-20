@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('invoices.index') }}">Invoices</a></li>
	<li class="is-active"><a>Invoice #{{ $invoice->number }}</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			Invoice #{{ $invoice->number }}
			@if ($invoice->deleted_at)
				<span class="tag is-dark">
					Archived
				</span>
			@endif
		@endslot
		@slot('subTitle')
			{{ $invoice->property->name }}
			@if (count($invoice->users))
				@foreach ($invoice->users as $user)
					<a href="{{ route('users.show', $user->id) }}">
						<span class="tag">
							{{ $user->name }}
						</span>
					</a>
				@endforeach
			@endif
		@endslot
	@endcomponent

	<section class="hero is-dark is-bold">
		<div class="hero-body">

			<nav class="level">
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Date
						</p>
						<p class="title">
							{{ date_formatted($invoice->created_at) }}
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Total
						</p>
						<p class="title">
							{{ currency($invoice->total) }}
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Net
						</p>
						<p class="title">
							{{ currency($invoice->total_net) }}
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Tax
						</p>
						<p class="title">
							{{ currency($invoice->total_tax) }}
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Payments
						</p>
						<p class="title">
							{{ currency($invoice->total_payments) }}
						</p>
					</div>
				</div>
				<div class="level-item has-text-centered">
					<div>
						<p class="heading">
							Balance
						</p>
						<p class="title">
							{{ currency($invoice->total_balance) }}
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
						Invoice
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('invoices.show', $invoice->id) }}" class="{{ set_active(route('invoices.show', $invoice->id)) }}">
								Items
							</a>
							<a href="{{ route('invoices.show', [$invoice->id, 'payments']) }}" class="{{ set_active(route('invoices.show', [$invoice->id, 'payments'])) }}">
								Payments
							</a>
							<a href="{{ route('invoices.show', [$invoice->id, 'settings']) }}" class="{{ set_active(route('invoices.show', [$invoice->id, 'settings'])) }}">
								Settings
							</a>
						</li>
					</ul>
					<p class="menu-label">
						Actions
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('invoices.show', [$invoice->id, 'delete']) }}" class="{{ set_active(route('invoices.show', [$invoice->id, 'delete'])) }}">
								Delete
							</a>
						</li>
					</ul>
				</aside>
			</div>
			<div class="column is-9">

				@yield('sub-content')

			</div>
		</div>

	@endcomponent

@endsection