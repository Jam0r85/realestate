@php
	$invoices->appends(['section' => 'invoices']);
@endphp

<div class="tab-pane fade @if (request('section') == 'invoices') show active @endif" id="v-pills-invoices" role="tabpanel">

	@include('invoices.partials.invoices-table', ['invoices' => $invoices])

	@include('partials.pagination', ['collection' => $invoices])
	
</div>