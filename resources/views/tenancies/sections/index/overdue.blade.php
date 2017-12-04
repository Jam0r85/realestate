<div class="tab-pane fade @if (request('section') == 'overdue') show active @endif" id="v-pills-overdue" role="tabpanel">

	@include('tenancies.partials.tenancies-table', ['tenancies' => $overdue_tenancies, 'daysOverdue' => true])
	
</div>