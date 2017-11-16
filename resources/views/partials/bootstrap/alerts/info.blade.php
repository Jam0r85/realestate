@component('partials.bootstrap.alerts.template')
	{{ $slot }}

	@slot('class')
		alert-info {{ isset($style) ? $style : '' }}
	@endslot

@endcomponent