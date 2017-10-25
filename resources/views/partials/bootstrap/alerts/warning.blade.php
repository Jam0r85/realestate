@component('partials.bootstrap.alerts.template')
	{{ $slot }}

	@slot('class')
		alert-warning {{ isset($style) ? $style : '' }}
	@endslot

@endcomponent