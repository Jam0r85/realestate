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
		Enter the rent payment amount.
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

<div class="field">
	<label class="checkbox">
		<input type="checkbox" name="create_auto_statement" value="true" checked />
		Create the next rental statement should there be enough rent held?
	</label>
</div>
