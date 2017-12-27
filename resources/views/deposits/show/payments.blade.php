<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Payments History
	@endcomponent

	@include('payments.partials.payments-table', ['payments' => $deposit->payments])

</div>

<div class="card mb-3">

	@component('partials.card-header')
		Record Payment
	@endcomponent

	<div class="card-body">

		<form method="POST" action="{{ route('deposits.store-payment', $deposit->id) }}">
			{{ csrf_field() }}

			<div class="form-group">
				<label for="created_at">Date Received</label>
				<input type="date" name="created_at" id="created_at" class="form-control" value="{{ old('created_at') ?? date('Y-m-d') }}" />
			</div>

			<div class="form-group">
				<label for="amount">Amount</label>
				<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required />
			</div>

			<div class="form-group">
				<label for="payment_method_id">Payment Method</label>
				<select name="payment_method_id" id="payment_method_id" class="form-control" required>
					@foreach (payment_methods() as $method)
						<option value="{{ $method->id }}">{{ $method->name }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label class="label">Payment Note (optional)</label>
				<textarea name="note" id="note" class="form-control" rows="6">{{ old('note') }}</textarea>
				<small class="form-text text-muted">
					Enter a note for this payment.
				</small>
			</div>

			@if (count($deposit->tenancy->users))
				<div class="form-group">
					<p class="text-muted">
						Select the user's to attach to this payment.
					</p>
					@foreach ($deposit->tenancy->users as $user)
						<label class="custom-control custom-checkbox">
							<input class="custom-control-input" type="checkbox" name="user_id[]" value="{{ $user->id }}" checked />
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description">{{ $user->present()->fullName }}</span>
						</label>
					@endforeach
				</div>
			@endif

			@component('partials.save-button')
				Record Payment
			@endcomponent

		</form>

	</div>
</div>