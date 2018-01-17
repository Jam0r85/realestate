@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">

			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newInvoiceItemModal">
				<i class="fa fa-plus"></i> New Item
			</button>

			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="invoiceOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					@icon('options') Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="invoiceOptionsDropdown">
					<a class="dropdown-item" href="{{ route('invoices.edit', $invoice->id) }}">
						@icon('edit') Edit Invoice
					</a>
					<a class="dropdown-item" href="{{ route('downloads.invoice', $invoice->id) }}" title="Download Invoice" target="_blank">
						@icon('download') Download as PDF
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			{{ $invoice->present()->name }}
			<span class="badge badge-secondary">
				{{ $invoice->present()->money('balance') }} balance
			</span>
		@endcomponent

		@if ($invoice->property)
			@component('partials.sub-header')
				{{ $invoice->present()->propertyAddress }}
			@endcomponent
		@endif

	@endcomponent

	@component('partials.section-with-container')

		@if ($invoice->deleted_at)
			@component('partials.alerts.dark')
				@icon('delete') This invoice was deleted <b>{{ $invoice->present()->dateDeleted }} }}</b>
			@endcomponent
		@endif

		@if ($invoice->paid_at)
			@component('partials.alerts.success')
				@icon('paid') This invoice was paid <b>{{ $invoice->present()->datePaid }}</b>
			@endcomponent
		@endif

		@if ($invoice->sent_at)
			@component('partials.alerts.success')
				@icon('sent') This invoice was sent <b>{{ $invoice->present()->dateSent }}</b>
			@endcomponent
		@endif

		@if ($invoice->isOverdue())
			@component('partials.alerts.warning')
				@icon('calendar') This invoice is overdue.
			@endcomponent
		@endif

		@if (count($invoice->statements))
			@component('partials.alerts.dark')
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
				<a class="nav-link @if (!Request::segment(3)) active @endif" href="{{ route('invoices.show', $invoice->id) }}">
					Details
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (Request::segment(3) == 'payments') active @endif" href="{{ route('invoices.show', [$invoice->id, 'payments']) }}">
					Payments
				</a>
			</li>
		</ul>

		@include('invoices.show.' . $show)

	@endcomponent

	@include('invoice-items.modals.new-item-modal', ['invoice' => $invoice])

@endsection