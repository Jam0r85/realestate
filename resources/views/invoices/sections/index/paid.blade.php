<div class="tab-pane fade @if (request('section') == 'paid') show active @endif" id="v-pills-paid" role="tabpanel">

	@include('invoices.partials.invoices-table', ['invoices' => $paid])

	@include('partials.pagination', ['collection' => $paid->appends(['section' => 'paid'])])
	
</div>