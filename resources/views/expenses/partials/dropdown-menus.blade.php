<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="expenseOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="expenseOptionsDropdown">
		<a class="dropdown-item" href="{{ route('expenses.show', [$expense->id, 'edit-details']) }}">
			Edit Expense Details
		</a>
		<a class="dropdown-item" href="{{ route('expenses.show', [$expense->id, 'manage-invoices']) }}">
			Manage Invoices
		</a>
	</div>
</div>

<div class="btn-group">
	<button class="btn btn-danger dropdown-toggle" type="button" id="expenseActionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Actions
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="expenseActionsDropdown">
		<a class="dropdown-item" href="{{ route('expenses.show', [$expense->id, 'delete-expense']) }}">
			Delete Expense
		</a>
	</div>
</div>