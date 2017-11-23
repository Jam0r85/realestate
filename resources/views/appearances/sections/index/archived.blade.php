<div class="tab-pane fade @if (request('section') == 'archived') show active @endif" id="v-pills-archived" role="tabpanel">

	@include('appearances.partials.appearances-table', ['appearances' => $archived_appearances])
	
</div>