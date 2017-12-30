@foreach ($user->notifications as $notification)

	<div class="card mb-3">
		@component('partials.card-header')
			{{ datetime_formatted($notification->created_at) }}
		@endcomponent

		@include('notifications.users.' . snake_case(class_basename($notification->type)))
	</div>

@endforeach