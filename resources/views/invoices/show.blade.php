@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">

			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newInvoiceItemModal">
				<i class="fa fa-plus"></i> New Item
			</button>

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
			{{ $invoice->present()->name }}
			<span class="badge badge-secondary">
				{{ currency($invoice->balance) }} balance
			</span>
		@endcomponent

		@if ($invoice->property)
			@component('partials.sub-header')
				{{ $invoice->property ? $invoice->property->present()->fullAddress : '' }}
			@endcomponent
		@endif

	@endcomponent

	@component('partials.section-with-container')

		@if ($invoice->isPaid())
			@component('partials.alerts.success')
				This invoice was paid {{ date_formatted($invoice->paid_at) }}
			@endcomponent
		@endif

		@if ($invoice->isSent())
			@component('partials.alerts.success')
				This invoice was sent {{ date_formatted($invoice->sent_at) }}
			@endcomponent
		@endif

		@if (count($invoice->statements))
			@component('partials.alerts.info')
				Invoice attached to the following statements:-
				<ul>
					@foreach ($invoice->statements as $statement)
						<li>
							<a href="{{ route('statements.show', $statement->id) }}">
								{{ $statement->present()->name }}
							</a>
						</li>
					@endforeach
				</ul>
			@endcomponent
		@endif

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

	@include('invoice-items.modals.new-item-modal', ['invoice' => $invoice])

@endsection