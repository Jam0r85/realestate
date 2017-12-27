<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Payments History
	@endcomponent

	@component('partials.table')
		@slot('header')
			<th>Date</th>
			<th>Method</th>
			<th>User(s)</th>
			<th class="text-right">Amount</th>
			<th></th>
		@endslot
		@slot('body')
			@foreach ($invoice->payments as $payment)
				<tr>
					<td>{{ date_formatted($payment->created_at) }}</td>
					<td>{{ $payment->method->name }}</td>
					<td>{!! $payment->present()->userBages !!}</td>
					<td class="text-right">{{ currency($payment->amount) }}</td>
					<td class="text-right">
						<a href="{{ route('payments.show', $payment->id) }}" class="btn btn-primary btn-sm">
							View
						</a>
						<a href="{{ route('downloads.payment', $payment->id) }}" target="_blank" class="btn btn-info btn-sm">
							<i class="fa fa-download"></i>
						</a>
					</td>
				</tr>
			@endforeach
			@foreach ($invoice->statementPayments as $payment)
				<tr>
					<td>{{ date_formatted($payment->created_at) }}</td>
					<td>Statement #{{ $payment->statement->id }}</td>
					<td>{!! $payment->present()->recipientNames !!}
					<td class="text-right">{{ currency($payment->amount) }}</td>
					<td class="text-right">
						<a href="{{ route('statement-payments.edit', $payment->id) }}" class="btn btn-primary btn-sm">
							Edit
						</a>
					</td>
				</tr>
			@endforeach
		@endslot
		@slot('footer')
			<tr>
				<td colspan="3">Total</td>
				<td class="text-right">{{ currency($invoice->present()->paymentsTotal) }}</td>
			</tr>
		@endslot
	@endcomponent

</div>

<div class="card mb-3">

	@component('partials.card-header')
		Record Payment
	@endcomponent

	<div class="card-body">

		<form method="POST" action="{{ route('invoices.store-payment', $invoice->id) }}">
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

			@if (count($invoice->users))
				<div class="form-group">
					<p class="text-muted">
						Select the user's that made this payment.
					</p>
					@foreach ($invoice->users as $user)
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