@foreach ($user->notifications as $notification)

	@component('partials.card')

		@include('users.notifications.' . snake_case(class_basename($notification->type)), [
			'notification' => $notification
		])

	@endcomponent

@endforeach