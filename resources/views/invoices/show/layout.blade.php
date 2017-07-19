@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('invoices.index') }}">Invoices</a></li>
	<li class="is-active"><a>Invoice #{{ $invoice->number }}</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			Invoice #{{ $invoice->number }}
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
			</nav>

		</div>
	</section>

	@component('partials.sections.section')

		<div class="columns is-flex is-column-mobile">
			<div class="column is-3">
				<aside class="menu">
					<p class="menu-label">
						Invoice Items
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('invoices.show', $invoice->id) }}" class="">
								Items List
							</a>
							<a href="{{ route('invoices.show', [$invoice->id, 'add-item']) }}" class="">
								Add Item
							</a>
						</li>
					</ul>
					<p class="menu-label">
						Settings
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('invoices.show', $invoice->id) }}" class="">
								Archive
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