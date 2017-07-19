@component('partials.notifications.notification')
	@slot('style')
		is-primary
	@endslot
	{{ $slot }}
@endcomponent