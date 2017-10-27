<form role="form" method="POST" action="{{ route('tenancies.create-rent-payment', $tenancy->id) }}">
	{{ csrf_field() }}

	<div class="form-group">
		<label for="created_at">Date (optional)</label>
		<input type="date" name="created_at" class="form-control" value="{{ old('created_at') }}" />
		<small class="form-text text-muted">
			Leave this blank to use the current date and time.
		</small>
	</div>

	<div class="form-group">
		<label for="amount">Amount</label>
		<input type="number" step="any" name="amount" class="form-control" value="{{ old('amount') }}" required />
	</div>

	<div class="form-group">
		<label for="payment_method_id">Payment Method</label>
		<select name="payment_method_id" class="form-control" required>
			@foreach (payment_methods() as $method)
				<option value="{{ $method->id }}">{{ $method->name }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		<label for="note">Note</label>
		<textarea name="note" class="form-control"></textarea>
		<small class="form-text text-muted">
			Enter an optional note to the user.
		</small>
	</div>

	<div class="form-group">
		<label class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" name="send_receipt_to_tenants" value="true">
			<span class="custom-control-indicator"></span>
			<span class="custom-control-description">Send notification and receipt by e-mail to tenants?</span>
		</label>
	</div>

	@component('partials.bootstrap.save-submit-button')
		Record Payment
	@endcomponent

</form>