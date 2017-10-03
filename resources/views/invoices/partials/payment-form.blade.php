<div class="form-group">
	<label for="created_at">Date Received (optional)</label>
	<input type="date" name="created_at" class="form-control" value="{{ old('created_at') }}" />
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
	<label class="label">Payment Note (optional)</label>
	<textarea name="note" class="form-control" rows="6">{{ old('note') }}</textarea>
	<small class="form-text text-muted">
		Enter a note for this payment.
	</small>
</div>

@if (count($invoice->users))
	<div class="form-group">
		<p class="text-muted">
			Select the user's that made this payment.
		</p>
		@foreach ($invoice->users as $user)
			<label class="custom-control custom-checkbox">
				<input class="custom-control-input" type="checkbox" name="user_id[]" value="{{ $user->id }}" checked />
				<span class="custom-control-indicator"></span>
				<span class="custom-control-description">{{ $user->name }}</span>
			</label>
		@endforeach
	</div>
@endif