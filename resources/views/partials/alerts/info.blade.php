@component('partials.bootstrap.alerts.info')
	{{ $slot }}
	
	@if (isset($style))
		@slot('style')
			{{ $style }}
		@endslot
	@endif

@endcomponent