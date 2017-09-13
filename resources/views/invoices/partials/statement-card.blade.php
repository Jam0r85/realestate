@if ($invoice->statement)
	<div class="card bg-info text-white mb-3">
		<div class="card-body">
			<h4 class="card-title">
				Rental Statement
			</h4>
			<p class="card-text">
				This invoice is attached to a rental statement.
			</p>
		</div>
		<div class="card-footer">
			<a href="{{ route('statements.show', $invoice->statement->id) }}" title="Statement #{{ $invoice->statement->id }}">
				View Statement #{{ $invoice->statement->id }}
			</a>
		</div>
	</div>
@endif