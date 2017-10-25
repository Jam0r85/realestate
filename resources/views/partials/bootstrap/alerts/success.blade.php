@component('partials.bootstrap.alerts.template')
	{{ $slot }}

	@slot('class')
		alert-success {{ isset($style) ? $style : '' }}
	@endslot

@endcomponent