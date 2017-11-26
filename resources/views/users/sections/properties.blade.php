<div class="tab-pane fade @if (request('section') == 'properties') show active @endif" id="v-pills-properties" role="tabpanel">

	@include('properties.partials.properties-table', ['properties' => $properties])
	
</div>