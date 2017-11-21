<div class="tab-pane fade" id="v-pills-invoices" role="tabpanel">

	@include('invoices.partials.invoices-table', ['invoices' => $user->invoices])
	
</div>