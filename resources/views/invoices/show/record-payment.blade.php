@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				Invoice {{ $invoice->name }}
			@endcomponent

			@component('partials.sub-header')
				Record a payment
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col-sm-12 col-md-5">

				@include('partials.errors-block')

				<div class="card mb-3">

					@component('partials.card-header')
						Record Payment
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('invoices.create-payment', $invoice->id) }}">
							{{ csrf_field() }}

							<div class="form-group">
								<label for="created_at">Date Received (optional)</label>
								<input type="date" name="created_at" id="created_at" class="form-control" value="{{ old('created_at') }}" />
								<small class="form-text text-muted">
									Leave blank to use the current date and time.
								</small>
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
											<span class="custom-control-description">{{ $user->name }}</span>
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

			</div>
			<div class="col-sm-12 col-md-7">

				<div class="card mb-3">

					@component('partials.card-header')
						Invoice Balance
					@endcomponent

					<ul class="list-group list-group-flush">
						@component('partials.bootstrap.list-group-item')
							{{ currency($invoice->total) }}
							@slot('title')
								Invoice Total
							@endslot
						@endcomponent
						@component('partials.bootstrap.list-group-item')
							{{ currency($invoice->total_balance) }}
							@slot('title')
								Balance Remaining
							@endslot
						@endcomponent
					</ul>
				</div>

				<div class="card mb-3">

					@component('partials.bootstrap.card-header')
						Payments History
					@endcomponent

					<table class="table table-striped table-hover table-responsive">
						<thead>
							<th>Date</th>
							<th>Amount</th>
							<th>Method</th>
							<th>User(s)</th>
						</thead>
						<tbody>
							@foreach ($invoice->payments as $payment)
								<tr>
									<td>{{ date_formatted($payment->created_at) }}</td>
									<td>{{ currency($payment->amount) }}</td>
									<td>{{ $payment->method->name }}</td>
									<td>
										@include('partials.bootstrap.users-inline', ['users' => $payment->users])
									</td>
								</tr>
							@endforeach
							@foreach ($invoice->statement_payments as $payment)
								<tr>
									<td>{{ date_formatted($payment->created_at) }}</td>
									<td>{{ currency($payment->amount) }}</td>
									<td>Statement #{{ $payment->statement->id }}</td>
									<td>
										@include('partials.bootstrap.users-inline', ['users' => $payment->users])
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

			</div>
		</div>

	@endcomponent

@endsection