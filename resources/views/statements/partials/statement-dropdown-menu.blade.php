<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="statementOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="statementOptionsDropdown">
		<a class="dropdown-item" href="{{ route('statements.show', [$statement->id, 'edit-statement-details']) }}">
			Edit Details
		</a>
		<a class="dropdown-item" href="{{ route('statements.show', [$statement->id, 'statement-options']) }}">
			Statement Options
		</a>
		<a class="dropdown-item" href="{{ route('statements.show', [$statement->id, 'new-invoice-item']) }}">
			New Invoice Item
		</a>
		<a class="dropdown-item" href="{{ route('downloads.statement', $statement->id) }}" target="_blank">
			Download Statement
		</a>
	</div>
</div>