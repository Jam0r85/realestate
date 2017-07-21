<div class="field">
	<label class="label" for="amount">Amount</label>
	<p class="control">
		<input type="number" step="any" name="amount" class="input" value="{{ old('amount') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="payment_method_id">Payment Method</label>
	<p class="control is-expanded">
		<span class="select is-fullwidth">
			<select name="payment_method_id">
				@foreach (payment_methods() as $method)
					<option value="{{ $method->id }}">{{ $method->name }}</option>
				@endforeach
			</select>
		</span>
	</p>
</div>