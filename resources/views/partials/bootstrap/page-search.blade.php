{{-- Search Field --}}
<div class="page-search">
	<form class="form-inline" role="form" method="POST" action="{{ $route }}">
		{{ csrf_field() }}

		<input type="text" name="search_term" class="form-control col-6" placeholder="Search for..." value="{{ isset($search_term) ? $search_term : '' }}" />
		
		@include('partials.bootstrap.search-button')

		{{-- Clear Search Button --}}
		@if (isset($search_term))
			@include('partials.bootstrap.clear-search-button')
		@endif
		{{-- End of Clear Search Button --}}

	</form>
</div>
{{-- End of Search Field --}}