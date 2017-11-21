@php
	$invoices = $user->invoices()->paginate();
@endphp

<div class="tab-pane fade" id="v-pills-invoices" role="tabpanel">

	@include('invoices.partials.invoices-table', ['invoices' => $invoices])

	@include('partials.pagination', ['collection' => $invoices])
	
</div>