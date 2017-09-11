<form role="form" method="POST" action="{{ route('tenancies.create-rental-statement', $tenancy->id)}}">
	{{ csrf_field() }}

	<div class="form-group">
		<label for="amount">Statement Amount</label>
		<input type="number" step="any" name="amount" class="form-control" value="{{ old('amount') }}" />
	</div>

	<div class="form-group">
		<label for="period_start">Start Date</label>
		<input type="date" name="period_start" class="form-control" value="{{ $tenancy->next_statement_start_date ? $tenancy->next_statement_start_date->format('Y-m-d') : '' }}" />
	</div>

	<div class="form-group">
		<label for="period_end">End Date</label>
		<input type="date" name="period_end" class="form-control" value="{{ old('period_end') }}" />
	</div>

	@component('partials.bootstrap.save-submit-button')
		Create Statement
	@endcomponent

</form>