@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('invoices.index') }}">Invoices</a></li>
	<li><a href="{{ route('settings.invoice-groups') }}">Groups</a></li>
	<li><a>{{ $invoice_group->name }}</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $invoice_group->name }}
		@endslot
	@endcomponent

	@component('partials.sections.section')

		<div class="columns">
			<div class="column is-3">

				{{-- Status Box --}}
				<article class="notification is-success has-text-centered">
					<p class="title">Active</p>
					<p class="subtitle">Next Number: <b>{{ $invoice_group->next_number }}</b></p>
				</article>

				{{-- Statistics --}}
				<article class="box">
					<div class="has-text-centered content">
						<p class="heading">
							Invoices Created
						</p>
						<p class="title">
							{{ count($invoice_group->invoices) }}
						</p>
					</div>
					<div class="has-text-centered content">
						<p class="heading">
							Invoices Total
						</p>
						<p class="title">
							{{ currency($invoice_group->invoices_total) }}
						</p>
					</div>
					<div class="has-text-centered content">
						<p class="heading">
							Financial Year
						</p>
						<p class="title">
							
						</p>
					</div>
				</article>

			</div>
			<div class="column is-9">

				<div class="tile is-child">
					@include('invoices.partials.table', ['invoices' => $invoice_group->invoices()->limit(30)->get(), 'property' => true])
				</div>

			</div>
		</div>

	@endcomponent

@endsection