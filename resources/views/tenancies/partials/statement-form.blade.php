<div class="field">
	<label class="label" for="amount">Statement Amount</label>
	<p class="control">
		<input type="number" step="any" name="amount" class="input" value="{{ old('amount') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="period_start">Start Date</label>
	<p class="control">
		<input type="date" name="period_start" class="input" value="{{ $tenancy->next_statement_start_date->format('Y-m-d') }}" />
	</p>
</div>

<div class="field">
	<label class="label" for="period_end">End Date</label>
	<p class="control">
		<input type="date" name="period_end" class="input" value="{{ old('period_end') }}" />
	</p>
</div>

<div class="field">
	<label class="label">Service Charge</label>
	<label class="checkbox">
		<input type="checkbox" name="service_charge" value="true" />
		Do not create service charge invoice?
	</label>
</div>