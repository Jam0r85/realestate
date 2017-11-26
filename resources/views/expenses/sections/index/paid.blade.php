<div class="tab-pane fade @if (request('section') == 'paid' || (!request('section') && $loop->first)) show active @endif" id="v-pills-paid" role="tabpanel">

	@include('expenses.partials.expenses-table', ['expenses' => $paid_expenses])

	@include('partials.pagination', ['collection' => $paid_expenses->appends(['section' => 'paid'])])
	
</div>