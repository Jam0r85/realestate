<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="paymentOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="paymentOptionsDropdown">
		<a class="dropdown-item" href="{{ route('payments.show', [$payment->id, 'edit-details']) }}" title="Edit Payment Details">
			Edit Payment Details
		</a>
		<a class="dropdown-item" href="{{ route('payments.show', [$payment->id, 'delete-payment']) }}" title="Delete Payment">
			Delete Payment
		</a>
	</div>
</div>