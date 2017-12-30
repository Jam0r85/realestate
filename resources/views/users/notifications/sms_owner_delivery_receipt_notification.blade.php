@component('partials.card-header')
	SMS Delivery Receipt
@endcomponent

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

<div class="card-footer">
	{{ datetime_formatted($notification->created_at) }}
</div>