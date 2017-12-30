<div class="card mb-3">

	@if (isset($header))
		@component('partials.card-header')
			{{ $header }}
		@endcomponent
	@endif

	{{ $slot }}

	@if (isset($footer))
		<div class="card-footer">
			{{ $footer }}
		</div>
	@endif

</div>