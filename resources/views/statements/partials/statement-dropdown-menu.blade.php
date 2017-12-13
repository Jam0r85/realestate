<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="statementOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="statementOptionsDropdown">
		<a class="dropdown-item" href="{{ route('statements.show', [$statement->id, 'update']) }}">
			Update Statement
		</a>
		<a class="dropdown-item" href="{{ route('downloads.statement', $statement->id) }}" target="_blank">
			Download Statement
		</a>
		<h5 class="dropdown-header">
			Invoices
		</h5>
		@if (count($statement->invoices))
			@foreach ($statement->invoices as $invoice)
				<a class="dropdown-item" href="{{ route('invoice-items.create', $invoice->id) }}">
					{{ $invoice->present()->name }} New Item
				</a>
			@endforeach
		@else
			<a class="dropdown-item" href="#">
				Create Invoice
			</a>
		@endif
	</div>
</div>