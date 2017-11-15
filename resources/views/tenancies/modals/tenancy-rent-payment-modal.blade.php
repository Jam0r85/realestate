<div class="modal fade" id="tenancyRentPaymentModal" tabindex="-1" role="dialog" aria-labelledby="tenancyRentPaymentModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form role="form" method="POST" action="{{ route('tenancies.create-rent-payment', $tenancy->id) }}">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="tenancyRentPaymentModalLabel">Record Rent Payment</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label for="created_at">Date (optional)</label>
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="date" name="created_at" id="created_at" class="form-control" value="{{ old('created_at') }}" />
						</div>
						<small class="form-text text-muted">
							Leave this blank to use the current date and time.
						</small>
					</div>

					<div class="form-group">
						<label for="amount">Amount</label>
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-gbp"></i>
							</span>
							<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" />
						</div>
						<small class="form-text text-muted">
							Leave blank to use the current rent amount of {{ currency($tenancy->currentRent->amount) }} as the payment amount.
						</small>
					</div>

					<div class="form-group">
						<label for="payment_method_id">Payment Method</label>
						<select name="payment_method_id" id="payment_method_id" class="form-control" required>
							@foreach (payment_methods() as $method)
								<option value="{{ $method->id }}">{{ $method->name }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="note">Note</label>
						<textarea name="note" id="note" class="form-control" rows="4"></textarea>
					</div>

					<div class="form-group">
						<label class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" name="send_receipt_to_tenants" value="true">
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description">Send a notification (including attached receipt) of this payment to the tenants?</span>
						</label>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					@component('partials.save-button')
						Record Payment
					@endcomponent
				</div>
			</div>
		</form>
	</div>
</div>