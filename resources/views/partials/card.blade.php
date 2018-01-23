<div class="card mb-3 {{ isset($style) ? $style : '' }}">

	@if (isset($header))
		@component('partials.card-header')
			{{ $header }}
		@endcomponent
	@endif

	{{ $slot }}

	@if (isset($body))
		<div class="card-body">
			{{ $body }}
		</div>
	@endif

	@if (isset($footer))
		<div class="card-footer">
			{{ $footer }}
		</div>
	@endif

</div>