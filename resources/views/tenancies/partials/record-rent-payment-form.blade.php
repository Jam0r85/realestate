<form role="form" method="POST" action="{{ route('tenancies.create-rent-payment', $tenancy->id) }}">
	{{ csrf_field() }}

	<div class="form-group">
		<label for="created_at">Date</label>
		<input type="date" name="created_at" class="form-control" value="{{ old('created_at') }}" />
	</div>

	<div class="form-group">
		<label for="amount">Amount</label>
		<input type="number" step="any" name="amount" class="form-control" value="{{ old('amount') }}" />
	</div>

	<div class="form-group">
		<label for="payment_method_id">Payment Method</label>
		<select name="payment_method_id" class="form-control">
			@foreach (payment_methods() as $method)
				<option value="{{ $method->id }}">{{ $method->name }}</option>
			@endforeach
		</select>
	</div>

	@component('partials.bootstrap.save-submit-button')
		Record Payment
	@endcomponent

</form>