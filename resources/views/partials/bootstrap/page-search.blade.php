{{-- Search Field --}}
<div class="page-search">
	<form method="POST" action="{{ $route }}">
		{{ csrf_field() }}

		<div class="input-group">
			<input type="text" name="search_term" class="form-control" placeholder="Search for..." value="{{ isset($search_term) ? $search_term : '' }}" />
			<span class="input-group-btn">
				<button type="submit" class="btn btn-secondary">
					<i class="fa fa-search"></i>
				</button>
			</span>
		</div>

		{{-- Clear Search Button --}}
		@if (isset($search_term))
			@include('partials.bootstrap.clear-search-button')
		@endif
		{{-- End of Clear Search Button --}}

	</form>
</div>
{{-- End of Search Field --}}