@foreach ($user->notifications as $notification)
	@include('users.notifications.' . snake_case(class_basename($notification->type)), [
		'notification' => $notification
	])
@endforeach