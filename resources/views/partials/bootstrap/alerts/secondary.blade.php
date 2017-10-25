@component('partials.bootstrap.alerts.template')
	{{ $slot }}

	@slot('class')
		alert-secondary {{ isset($style) ? $style : '' }}
	@endslot

@endcomponent