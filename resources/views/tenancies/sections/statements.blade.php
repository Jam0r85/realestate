@php
	$statements = $tenancy->statements()->with('tenancy')->paginate();
	$statements->appends(['section' => 'statements']);
@endphp

<div class="tab-pane fade @if (request('section') == 'statements') show active @endif" id="v-pills-statements" role="tabpanel">

	@include('statements.partials.statements-table')
	@include('partials.pagination', ['collection' => $statements])
	
</div>