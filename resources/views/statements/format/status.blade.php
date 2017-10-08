@if ($statement->sent_at)
	Sent
@else
	@if ($statement->paid_at)
		Paid
	@else
		Unpaid
	@endif
@endif