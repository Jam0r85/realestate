<div class="tab-pane fade @if (request('section') == 'all-tenancies' || (!request('section') && $loop->first)) show active @endif" id="v-pills-all-tenancies" role="tabpanel">

	@include('tenancies.partials.tenancies-table', ['tenancies' => $all_tenancies])

	@include('partials.pagination', ['collection' => $all_tenancies->appends(['section' => 'all-tenancies'])])
	
</div>