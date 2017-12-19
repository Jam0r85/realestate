<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="statementOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="statementOptionsDropdown">
		<a class="dropdown-item" href="{{ route('statements.edit', $statement->id) }}">
			Edit Statement
		</a>
		<a class="dropdown-item" href="{{ route('downloads.statement', $statement->id) }}" target="_blank">
			Download Statement
		</a>
		<h5 class="dropdown-header">
			Invoices
		</h5>
		@if (!count($statement->invoices))
			<a class="dropdown-item" href="#">
				Create Invoice
			</a>
		@endif
	</div>
</div>