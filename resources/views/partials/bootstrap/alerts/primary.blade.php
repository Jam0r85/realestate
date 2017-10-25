@component('partials.bootstrap.alerts.template')
	{{ $slot }}

	@slot('class')
		alert-primary {{ isset($style) ? $style : '' }}
	@endslot

@endcomponent