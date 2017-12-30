@component('users.notifications.template')
	@slot('header')
		SMS Delivery Receipt
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