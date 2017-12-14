@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">

			<a href="{{ route('invoice-items.create', $invoice->id) }}" class="btn btn-primary">
				<i class="fa fa-plus"></i> New Item
			</a>

			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="invoiceOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="invoiceOptionsDropdown">
					<a class="dropdown-item" href="{{ route('invoices.edit', $invoice->id) }}">
						<i class="fa fa-edit"></i> Edit Invoice
					</a>
					<a class="dropdown-item" href="{{ route('downloads.invoice', $invoice->id) }}" title="Download Invoice" target="_blank">
						<i class="fa fa-download"></i> Download as PDF
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			Invoice {{ $invoice->present()->name }}
		@endcomponent

		@if ($invoice->property)
			@component('partials.sub-header')
				{{ $invoice->property ? $invoice->property->present()->fullAddress : '' }}
			@endcomponent
		@endif

	@endcomponent

	@component('partials.section-with-container')

		@includeIf($invoice->paid_at, 'partials.alerts.success', ['slot' => 'This invoice was paid ' . date_formatted($invoice->paid_at)])

		<ul class="nav nav-pills">
			<li class="nav-item">
				{!! Menu::showLink('Details', 'invoices.show', $invoice->id, 'index') !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Payments', 'invoices.show', $invoice->id, 'payments') !!}
			</li>
		</ul>

		@include('invoices.show.' . $show)

	@endcomponent

@endsection