<div class="field">
	<label class="label" for="amount">Statement Amount</label>
	<div class="control">
		<input type="number" step="any" name="amount" class="input" value="{{ old('amount') }}" />
	</div>
	<p class="help">
		Enter the amount of the statement of leave blank.
	</p>
</div>

<div class="field">
	<label class="label" for="period_start">Start Date</label>
	<div class="control">
		<input type="date" name="period_start" class="input" value="{{ $tenancy->next_statement_start_date->format('Y-m-d') }}" />
	</div>
	<p class="help">
		Enter the start date of the statement or leave blank.
	</p>
</div>

<div class="field">
	<label class="label" for="period_end">End Date</label>
	<div class="control">
		<input type="date" name="period_end" class="input" value="{{ old('period_end') }}" />
	</div>
	<p class="help">
		Enter the end date of the statement or leave blank.
	</p>
</div>