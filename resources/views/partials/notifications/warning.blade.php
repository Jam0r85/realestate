@component('partials.notifications.notification')
	@slot('style')
		is-warning
	@endslot
	{{ $slot }}
@endcomponent