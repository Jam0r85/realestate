<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="bankAccountOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="bankAccountOptionsDropdown">
		<a class="dropdown-item" href="{{ route('bank-accounts.show', [$account->id, 'edit-details']) }}">
			Edit Bank Account
		</a>
	</div>
</div>