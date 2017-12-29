<div class="input-group">
	<div class="input-group-prepend">
		<span class="input-group-text">
			@component('partials.icon')
				{{ $icon }}
			@endcomponent
		</span>
	</div>

	{{ $slot }}
</div>