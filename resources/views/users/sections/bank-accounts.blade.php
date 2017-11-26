<div class="tab-pane fade @if (request('section') == 'bank-accounts') show active @endif" id="v-pills-bank-accounts" role="tabpanel">

	@include('bank-accounts.partials.bank-accounts-table', ['accounts' => $bank_accounts])
	
</div>