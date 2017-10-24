@component('partials.bootstrap.card-header')
	{{ $slot }}

	@if (isset($style))
		@slot('style')
			{{ $style }}
		@endslot
	@endif

@endcomponent