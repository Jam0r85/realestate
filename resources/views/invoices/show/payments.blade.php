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
		@endslot
		@slot('body')
			@foreach ($invoice->payments as $payment)
				<tr class="clickable-row" data-href="{{ route('payments.edit', $payment->id) }}" data-toggle="tooltip" data-placement="left" title="Edit Payment">
					<td>{{ $payment->present()->dateCreated }}</td>
					<td>{{ $payment->method->name }}</td>
					<td>{!! $payment->present()->userBadges !!}</td>
					<td class="text-right">{{ $payment->present()->money('amount') }}</td>
				</tr>
			@endforeach
			@foreach ($invoice->statementPayments as $payment)
				<tr class="clickable-row" data-href="{{ route('statement-payments.edit', $payment->id) }}" data-toggle="tooltip" data-placement="left" title="Edit Statement Payment">
					<td>{{ $payment->present()->dateCreated }}</td>
					<td>Statement #{{ $payment->statement->id }}</td>
					<td>{!! $payment->present()->userBadges !!}
					<td class="text-right">{{ $payment->present()->money('amount') }}</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent

</div>

<form method="POST" action="{{ route('invoices.store-payment', $invoice->id) }}">
	{{ csrf_field() }}

	@component('partials.card')
		@slot('header')
			Record Payment
		@endslot
		@slot('body')

			@if (! commonCount('payment-methods'))
				@component('partials.alerts.warning')
					@icon('warning') You must create at least one <a href="{{ route('payment-methods.create') }}">payment method</a> before you can record any payments.
				@endcomponent
			@else

				@component('partials.form-group')
					@slot('label')
						Date
					@endslot
					@component('partials.input-group')
						@slot('icon')
							@icon('calendar')
						@endslot
						<input type="date" name="created_at" id="created_at" class="form-control" value="{{ old('created_at') ?? date('Y-m-d') }}" />
					@endcomponent
				@endcomponent

				@component('partials.form-group')
					@slot('label')
						Amount
					@endslot
					@component('partials.input-group')
						@slot('icon')
							@icon('money')
						@endslot
						<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required />
					@endcomponent
				@endcomponent

				@component('partials.form-group')
					@slot('label')
						Payment Method
					@endslot
					<select name="payment_method_id" id="payment_method_id" class="form-control" required>
						@foreach (common('payment-methods') as $method)
							<option value="{{ $method->id }}">
								{{ $method->name }}
							</option>
						@endforeach
					</select>
				@endcomponent

				@component('partials.form-group')
					@slot('label')
						Note
					@endslot
					@slot('help')
						Enter a private note for this payment.
					@endslot
					<textarea name="note" id="note" class="form-control" rows="6">{{ old('note') }}</textarea>
				@endcomponent

				@if (count($invoice->users))
					@component('partials.form-group')
						<p class="text-muted">
							Select the user's that made this payment.
						</p>
						@foreach ($invoice->users as $user)
							<div class="form-check">
								<input class="form-check-inputt" type="checkbox" name="user_id[]" id="user_{{ $user->id }}" value="{{ $user->id }}" checked />
								<label class="form-check-label" for="user_{{ $user->id }}">
									{{ $user->present()->fullName }}
								</label>
							</div>
						@endforeach
					@endcomponent
				@endif

			@endif

		@endslot
		@if (commonCount('payment-methods'))
			@slot('footer')
				@component('partials.save-button')
					Record Payment
				@endcomponent
			@endslot
		@endif
	@endcomponent

</form>