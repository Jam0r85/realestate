<div class="tab-pane fade @if (request('section') == 'owes-rent') show active @endif" id="v-pills-owes-rent" role="tabpanel">

	@include('tenancies.partials.tenancies-table', ['tenancies' => $owes_rent])

	@include('partials.pagination', ['collection' => $owes_rent->appends(['section' => 'owes-rent'])])
	
</div>