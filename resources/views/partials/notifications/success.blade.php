@component('partials.notifications.notification')
	@slot('style')
		is-success
	@endslot
	{{ $slot }}
@endcomponent