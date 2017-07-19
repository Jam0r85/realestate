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

		<div class="tile is-ancestor">
			<div class="tile is-vertical is-parent is-3">
				@if (!$invoice_group->trashed())

					{{-- Status Box --}}
					<article class="tile is-child notification is-success">
						<p class="title">Active</p>
						<p class="subtitle">Next Number: <b>{{ $invoice_group->next_number }}</b></p>
					</article>

					{{-- Statistics --}}
					<article class="tile is-child box">
						<div class="has-text-centered">
							<p class="heading">
								Invoices Created
							</p>
							<p class="title">
								{{ count($invoice_group->invoices) }}
							</p>
						</div>
						<div class="has-text-centered">
							<p class="heading">
								Invoices Total
							</p>
							<p class="title">
								{{ currency($invoice_group->invoices_total) }}
							</p>
						</div>
					</article>

					{{-- Update Status --}}
					<article class="tile is-child notification is-light">
						<div class="content">
							<p>
								You can archive this invoice group and prevent it from being used in the future.
							</p>
						</div>

						<form role="form" method="POST" action="{{ route('invoice-groups.archive', $invoice_group->id) }}">
							{{ csrf_field() }}

							<button type="submit" class="button">
								Archive Invoice Group
							</button>
						</form>

					</article>
				@else
					<article class="tile is-child notification is-dark">
						<p class="title">Archived</p>
					</article>
				@endif
			</div>
			<div class="tile is-vertical is-parent is-9">
				<div class="tile is-child">
					@include('invoices.partials.table', ['invoices' => $invoice_group->invoices, 'property' => true])
				</div>
			</div>
		</div>


	@endcomponent

@endsection