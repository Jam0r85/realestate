<div class="card-body">
	<blockquote class="blockquote">
		<p class="mb-0">
			{{ $notification->data['text'] }}
		</p>
		<footer class="blockquote-footer">
			SMS message sent by {{ $notification->data['user'] }}
		</footer>
	</blockquote>
</div>