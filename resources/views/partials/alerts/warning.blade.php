@component('partials.bootstrap.alerts.warning')
	{{ $slot }}
	
	@if (isset($style))
		@slot('style')
			{{ $style }}
		@endslot
	@endif

@endcomponent