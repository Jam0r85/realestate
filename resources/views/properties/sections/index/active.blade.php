<div class="tab-pane fade @if (request('section') == 'active' || (!request('section') && $loop->first)) show active @endif" id="v-pills-active" role="tabpanel">

	@include('properties.partials.properties-table', ['properties' => $active])

	@include('partials.pagination', ['collection' => $active->appends(['section' => 'active'])])
	
</div>