<form method="POST" action="{{ route('statement-payments.send', $payment->id) }}">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
	<button type="submit" class="btn btn-primary btn-sm">
		Sent
	</button>
</form>