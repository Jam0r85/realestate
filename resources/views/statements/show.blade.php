@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="mb-2 text-right">

			@if (count($statement->invoices))
				@foreach ($statement->invoices as $invoice)
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newInvoiceItemModal" data-invoice="{{ $invoice->id }}">
						<i class="fa fa-plus"></i> Invoice Item
					</button>
				@endforeach
			@endif

			@if (count($statement->tenancy->property->unpaidExpenses))
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#statementExpenseAttachModal">
					<i class="fa fa-plus"></i> Expense Item
				</button>
			@endif

			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="statementOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-cogs"></i> Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="statementOptionsDropdown">
					<a class="dropdown-item" href="{{ route('statements.edit', $statement->id) }}">
						<i class="fa fa-edit"></i> Edit Statement
					</a>
					<a class="dropdown-item" href="{{ route('downloads.statement', $statement->id) }}" target="_blank">
						<i class="fa fa-download"></i> Download Statement
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			Statement #{{ $statement->id }}
			<span class="badge badge-secondary">
				{{ money_formatted($statement->present()->landlordBalanceTotal) }} to landlord
			</span>
		@endcomponent

		@component('partials.sub-header')
			{{ $statement->tenancy->present()->name }}
		@endcomponent
		
	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		@if ($statement->deleted_at)
			@component('partials.alerts.secondary')
				@icon('delete') This statement was deleted <b>{{ $statement->present()->dateDeleted }}</b>
			@endcomponent
		@endif

		@if ($statement->paid_at)
			@component('partials.alerts.success')
				@icon('paid') This statement was paid <b>{{ $statement->present()->datePaid }}</b>
			@endcomponent
		@endif

		@if ($statement->sent_at)
			@component('partials.alerts.success')
				@icon('sent') This statement was sent <b>{{ $statement->present()->dateSent }}</b>
			@endcomponent
		@endif

		<ul class="nav nav-pills">
			<li class="nav-item">
				<a class="nav-link @if (!Request::segment(3)) active @endif" href="{{ route('statements.show', $statement->id) }}">
					Details
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (Request::segment(3) == 'items') active @endif" href="{{ route('statements.show', [$statement->id, 'items']) }}">
					Items
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if (Request::segment(3) == 'payments') active @endif" href="{{ route('statements.show', [$statement->id, 'payments']) }}">
					Payments
				</a>			</li>
		</ul>

		@include('statements.show.' . $show)

	@endcomponent

	@include('invoice-items.modals.new-item-modal')
	@if (count($statement->tenancy->property->unpaidExpenses))
		@include('expenses.modals.statement-expense-attach-modal')
	@endif

@endsection

@push('footer_scripts')
<script>
	$('#newInvoiceItemModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var invoice_id = button.data('invoice') // Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this)
		modal.find('#invoice_id').val(invoice_id)
	})
</script>
@endpush