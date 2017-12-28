@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@if (count($statement->invoices))
				@foreach ($statement->invoices as $invoice)
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newInvoiceItemModal" data-invoice="{{ $invoice->id }}">
						<i class="fa fa-plus"></i> New Item
					</button>
				@endforeach
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
		@endcomponent

		@component('partials.sub-header')
			{{ $statement->tenancy->present()->name }}
		@endcomponent
		
	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		@if ($statement->paid_at)
			@component('partials.alerts.success')
				This statement was paid on {{ date_formatted($statement->paid_at) }}
			@endcomponent
		@endif

		@if ($statement->sent_at)
			@component('partials.alerts.success')
				This statement was sent on {{ date_formatted($statement->sent_at) }}
			@endcomponent
		@endif

		<ul class="nav nav-pills">
			<li class="nav-item">
				{!! Menu::showLink('Details', 'statements.show', $statement->id, 'index') !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Items', 'statements.show', $statement->id) !!}
			</li>
			<li class="nav-item">
				{!! Menu::showLink('Payments', 'statements.show', $statement->id) !!}
			</li>
		</ul>

		@include('statements.show.' . $show)

	@endcomponent

	@include('invoice-items.modals.new-item-modal')

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