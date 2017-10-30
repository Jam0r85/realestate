<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="expenseOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="expenseOptionsDropdown">
		<a class="dropdown-item" href="{{ route('expenses.show', [$expense->id, 'edit-details']) }}">
			Expense Details
		</a>
		<a class="dropdown-item" href="{{ route('expenses.show', [$expense->id, 'expense-status']) }}">
			Expense Status
		</a>
	</div>
</div>