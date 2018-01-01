@if (Storage::exists($path))
	<a href="{{ Storage::url($path) }}" class="btn btn-secondary btn-sm" target="_blank">
		@icon('download')
	</a>
@else
	<button type="button" class="btn btn-secondary btn-sm" disabled>
		@icon('download') <em>Missing</em>
	</button>
@endif