<div class="tab-pane fade @if (request('section') == 'vacated') show active @endif" id="v-pills-vacated" role="tabpanel">

	@include('tenancies.partials.tenancies-table', ['tenancies' => $vacated_tenancies])

	@include('partials.pagination', ['collection' => $vacated_tenancies->appends(['section' => 'vacated'])])
	
</div>