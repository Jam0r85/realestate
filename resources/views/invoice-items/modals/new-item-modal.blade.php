<div class="modal fade" id="newInvoiceItemModal" tabindex="-1" role="dialog" aria-labelledby="newInvoiceItemModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form role="form" method="POST" action="{{ route('invoice-items.store') }}">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newInvoiceItemModal">New Item</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<input type="hidden" name="invoice_id" id="invoice_id" value="{{ isset($invoice) ? $invoice->id : '' }}" />

					@include('invoice-items.partials.form')

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					@component('partials.save-button')
						Save Item
					@endcomponent
				</div>
			</div>
		</form>
	</div>
</div>