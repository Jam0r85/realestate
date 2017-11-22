@php
	$statements = $tenancy->statements()->with('invoices','invoices.invoiceGroup','invoices.items','invoices.items.taxRate','expenses','payments')->paginate();
	$statements->appends(['section' => 'statements']);
@endphp

<div class="tab-pane fade @if (request('section') == 'statements') show active @endif" id="v-pills-statements" role="tabpanel">

	@include('statements.partials.statements-table')
	@include('partials.pagination', ['collection' => $statements])
	
</div>