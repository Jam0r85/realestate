@component('users.notifications.template')
	@slot('header')
		@if (!$notification->read_at)
			<span class="badge badge-danger float-right">
				Unread!
			</span>
		@endif
		SMS Delivery Receipt
	@endslot
	@slot('footer')
		{{ datetime_formatted($notification->created_at) }}
	@endslot

	<div class="card-body">
		<blockquote class="blockquote">
			<p class="mb-0">
				{{ $notification->data['text'] }}
			</p>
			<footer class="blockquote-footer">
				SMS message to {{ $notification->data['recipient'] }} was {{ $notification->data['status'] }}
			</footer>
		</blockquote>
	</div>
@endcomponent