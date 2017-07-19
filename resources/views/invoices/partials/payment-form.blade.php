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

<div class="field">
	<label class="label" for="note">Payment Note</label>
	<p class="control">
		<textarea name="note" class="textarea">{{ old('note') }}</textarea>
	</p>
</div>

@if (count($invoice->users))
	<div class="field">
		<label class="label">From Users</label>
		@foreach ($invoice->users as $user)
			<label class="checkbox">
				<input type="checkbox" name="user_id[]" value="{{ $user->id }}" checked />
				{{ $user->name }}
			</label>
		@endforeach
	</div>
@endif