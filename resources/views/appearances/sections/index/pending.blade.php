<div class="tab-pane fade @if (request('section') == 'pending') show active @endif" id="v-pills-pending" role="tabpanel">

	@include('appearances.partials.appearances-table', ['appearances' => $pending_appearances])
	
</div>