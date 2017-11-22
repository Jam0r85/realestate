<form method="POST" action="{{ route('statement-payments.update', $payment->id) }}">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
	<input type="hidden" name="sent_at" value="{{ \Carbon\Carbon::now() }}" />
	<button type="submit" class="btn btn-primary btn-sm">
		Mark as Sent
	</button>
</form>