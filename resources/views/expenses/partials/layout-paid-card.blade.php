@if ($expense->paid_at)

	<div class="notification is-success has-text-centered">
		Paid {{ date_formatted($expense->paid_at) }}
	</div>

@else

	@if ($expense->balance_amount <= 0)

		<div class="notification is-info has-text-centered">
			{{ currency($expense->balance_amount) }}, waiting to be marked as paid.
		</div>

	@endif

@endif