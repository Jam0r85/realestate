<div class="tab-pane fade @if (request('section') == 'hidden') show active @endif" id="v-pills-hidden" role="tabpanel">

	@include('appearances.partials.appearances-table', ['appearances' => $hidden_appearances])
	
</div>