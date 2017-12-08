<div class="tab-pane fade @if (request('section') == 'archived') show active @endif" id="v-pills-archived" role="tabpanel">

	@include('properties.partials.properties-table', ['properties' => $archived])

	@include('partials.pagination', ['collection' => $archived->appends(['section' => 'archived'])])
	
</div>