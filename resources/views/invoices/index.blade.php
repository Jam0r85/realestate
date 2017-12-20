@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="mb-3 text-right">
			<a href="{{ route('invoices.create') }}" class="btn btn-primary">
				<i class="fa fa-plus"></i> New Invoice
			</a>
		</div>

		@component('partials.header')
			Invoices List
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col-12 col-lg-4">

				<div class="card text-white bg-dark mb-3">
					<div class="card-body text-center">

						<h2>{{ currency($totals['net']) }}</h2>
						<span class="text-muted">
							<b>NET</b>
						</span>

					</div>
				</div>

			</div>
			<div class="col-12 col-lg-4">

				<div class="card text-white bg-dark mb-3">
					<div class="card-body text-center">

						<h2>{{ currency($totals['tax']) }}</h2>
						<span class="text-muted">
							<b>TAX</b>
						</span>

					</div>
				</div>

			</div>
			<div class="col-12 col-lg-4">

				<div class="card text-white bg-dark mb-3">
					<div class="card-body text-center">

						<h2>{{ currency($totals['total']) }}</h2>
						<span class="text-muted">
							<b>TOTAL</b>
						</span>

					</div>
				</div>

			</div>
		</div>

		@include('partials.index-search', ['route' => 'invoices.search', 'session' => 'invoice_search_term'])

		<ul class="nav nav-pills">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ request('group') ? slug_to_name(request('group')) : 'Group' }}
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item @if (!request('group')) active @endif" href="{{ Filter::link(['group' => null]) }}">
						All Groups
					</a>
					<div class="dropdown-divider"></div>
					@foreach (invoiceGroups() as $group)
						<a class="dropdown-item @if (request('group') == $group->slug) active @endif" href="{{ Filter::link(['group' => $group->slug]) }}">
							{{ $group->name }}
						</a>
					@endforeach
				</div>
			</li>
			{!! (new Filter())->monthDropdown() !!}
			{!! (new Filter())->yearDropdown('App\Invoice') !!}
			{!! Filter::paidPill() !!}
			{!! Filter::unpaidPill() !!}
			{!! Filter::archivePill() !!}
			{!! Filter::clearButton() !!}
		</ul>

		@include('invoices.partials.invoices-table')
		@include('partials.pagination', ['collection' => $invoices])
	
	@endcomponent

@endsection