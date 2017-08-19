<div class="field">
	<label class="label" for="created_at">Date</label>
	<div class="control">
		<input type="date" name="created_at" class="input" value="{{ old('created_at') }}" />
	</div>
	<p class="help">
		You can manually set the date or leave blank to use today's date.
	</p>
</div>

<div class="field">
	<label class="label" for="amount">Amount</label>
	<div class="control">
		<input type="number" step="any" name="amount" class="input" value="{{ old('amount') }}" />
	</div>
	<p class="help">
		Enter the rent amount being paid.
	</p>
</div>

<div class="field">
	<label class="label" for="payment_method_id">Payment Method</label>
	<div class="control">
		<span class="select is-fullwidth">
			<select name="payment_method_id">
				@foreach (payment_methods() as $method)
					<option value="{{ $method->id }}">{{ $method->name }}</option>
				@endforeach
			</select>
		</span>
	</div>
	<p class="help">
		Select how they paid their rent.
	</p>
</div>