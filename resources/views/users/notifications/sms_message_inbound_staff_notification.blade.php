@component('partials.card')

	@slot('header')
		@if (!$notification->read_at)
			<span class="badge badge-danger float-right">
				Unread!
			</span>
		@endif
		SMS Received
	@endslot

	@slot('footer')
		{{ datetime_formatted($notification->created_at) }}
	@endslot

	@slot('body')
		<blockquote class="blockquote">
			<p class="mb-0">
				{{ $notification->data['text'] }}
			</p>
			<footer class="blockquote-footer">
				SMS message sent by <a href="{{ route('users.show', $notification->notifiable->user_id) }}">{{ $notification->data['user'] }}</a>
			</footer>
		</blockquote>
	@endslot
@endcomponent