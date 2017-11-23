<div class="tab-pane fade @if (request('section') == 'live' || (!request('section') && $loop->first)) show active @endif" id="v-pills-live" role="tabpanel">

	@include('appearances.partials.appearances-table', ['appearances' => $live_appearances])

	@include('partials.pagination', ['collection' => $live_appearances->appends(['section' => 'live'])])
	
</div>