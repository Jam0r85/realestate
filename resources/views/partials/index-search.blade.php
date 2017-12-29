{{-- Search Field --}}
<div class="page-search">

	@include('partials.errors-block')
	
	<form method="POST" action="{{ route($route) }}">
		{{ csrf_field() }}

		<div class="input-group">
			<input type="text" name="search_term" class="form-control" placeholder="Search for..." value="{{ isset($session) ? session()->get($session) : '' }}" />
			<div class="input-group-append">
				<button type="submit" class="btn btn-outline-secondary">
					Search
				</button>
			</div>
		</div>

		{{-- Clear Search Button --}}
		@if (session()->has($session))
			@include('partials.bootstrap.clear-search-button')
		@endif
		{{-- End of Clear Search Button --}}

	</form>
</div>
{{-- End of Search Field --}}