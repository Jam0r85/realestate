<div class="tab-pane fade @if (request('section') == 'has-rent') show active @endif" id="v-pills-has-rent" role="tabpanel">

	@include('tenancies.partials.tenancies-table', ['tenancies' => $has_rent])

	@include('partials.pagination', ['collection' => $has_rent->appends(['section' => 'has-rent'])])
	
</div>