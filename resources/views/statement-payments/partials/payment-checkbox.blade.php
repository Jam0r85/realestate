<form method="POST" action="{{ route('statement-payments.send', $payment->id) }}" class="d-inline">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
	<button type="submit" class="btn btn-primary btn-sm" title="Send">
		@icon('sent')
	</button>
</form>

<a href="{{ route('statement-payments.edit', $payment->id) }}" class="btn btn-warning btn-sm">
	@icon('edit')
</a>