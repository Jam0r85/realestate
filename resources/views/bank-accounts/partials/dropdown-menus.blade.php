<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="bankAccountOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="bankAccountOptionsDropdown">
		<a class="dropdown-item" href="{{ route('bank-accounts.show', [$account->id, 'edit-details']) }}">
			Edit Bank Account Details
		</a>
		<a class="dropdown-item" href="{{ route('bank-accounts.show', [$account->id, 'edit-users']) }}">
			Update Linked Users
		</a>
	</div>
</div>

<div class="btn-group">
	<button class="btn btn-danger dropdown-toggle" type="button" id="bankAccountActionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Actions
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="bankAccountActionsDropdown">
		<a class="dropdown-item" href="{{ route('bank-accounts.show', [$account->id, 'archive-bank-account']) }}">
			Archive Bank Account
		</a>
	</div>
</div>