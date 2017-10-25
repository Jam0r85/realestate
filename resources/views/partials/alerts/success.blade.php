@component('partials.bootstrap.alerts.success')
	{{ $slot }}
	
	@if (isset($style))
		@slot('style')
			{{ $style }}
		@endslot
	@endif

@endcomponent