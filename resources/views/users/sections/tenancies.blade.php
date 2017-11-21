<div class="tab-pane fade @if (request('section') == 'tenancies') show active @endif" id="v-pills-tenancies" role="tabpanel">

	@include('tenancies.partials.tenancies-table', ['tenancies' => $user->tenancies])
	
</div>