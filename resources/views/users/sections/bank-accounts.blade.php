<div class="tab-pane fade" id="v-pills-bank-accounts" role="tabpanel">

	@include('bank-accounts.partials.bank-accounts-table', ['accounts' => $user->bankAccounts])
	
</div>