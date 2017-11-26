<div class="tab-pane fade @if (request('section') == 'active' || (!request('section') && $loop->first)) show active @endif" id="v-pills-active" role="tabpanel">

	@include('properties.partials.properties-table', ['properties' => $active_properties])

	@include('partials.pagination', ['collection' => $active_properties->appends(['section' => 'active'])])
	
</div>