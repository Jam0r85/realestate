@component('partials.bootstrap.alerts.secondary')
	{{ $slot }}
	
	@if (isset($style))
		@slot('style')
			{{ $style }}
		@endslot
	@endif

@endcomponent