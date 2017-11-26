<div class="tab-pane fade @if (request('section') == 'archived') show active @endif" id="v-pills-archived" role="tabpanel">

	@include('tenancies.partials.tenancies-table', ['tenancies' => $archived_tenancies])

	@include('partials.pagination', ['collection' => $archived_tenancies->appends(['section' => 'archived'])])
	
</div>