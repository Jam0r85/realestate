@component('users.notifications.template')
	@slot('header')
		SMS Received
	@endslot

	<div class="card-body">
		<blockquote class="blockquote">
			<p class="mb-0">
				{{ $notification->data['text'] }}
			</p>
			<footer class="blockquote-footer">
				SMS message sent by <a href="{{ route('users.show', $notification->notifiable->user_id) }}">{{ $notification->data['user'] }}</a>
			</footer>
		</blockquote>
	</div>
@endcomponent