@component('partials.bootstrap.alerts.primary')
	{{ $slot }}
	
	@if (isset($style))
		@slot('style')
			{{ $style }}
		@endslot
	@endif

@endcomponent