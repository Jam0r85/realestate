<div class="tab-pane fade @if (request('section') == 'sent') show active @endif" id="v-pills-sent" role="tabpanel">

	@include('statements.partials.statements-table', ['statements' => $sent])

	@include('partials.pagination', ['collection' => $sent->appends(['section' => 'sent'])])
	
</div>