@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<a href="{{ route('tenancies.show', $tenancy->id) }}" class="btn btn-secondary float-right">
				Return
			</a>
			<h1>{{ $tenancy->name }}</h1>
			<h3 class="text-muted">
				{{ $tenancy->deposit ? 'Manage the deposit' : 'Record a deposit ' }}
			</h3>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="card mb-3">
			<h4 class="card-header">
				Deposit Details
			</h4>
			<div class="card-body">

				@if ($tenancy->deposit)
					<form method="POST" action="{{ route('deposit.update', $tenancy->deposit->id) }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
				@else
					<form method="POST" action="{{ route('deposit.store') }}">
						{{ csrf_field() }}
						<input type="hidden" name="tenancy_id" value="{{ $tenancy->id }}">
				@endif

					<div class="form-group">
						<label for="amount">Deposit Amount</label>
						<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ $tenancy->deposit ? $tenancy->deposit->amount : old('amount') }}" />
					</div>

					<div class="form-group">
						<label for="unique_id">Unique Reference (certificate number)</label>
						<input type="text" name="unique_id" id="unique_id" class="form-control" value="{{ $tenancy->deposit ? $tenancy->deposit->unique_id : old('unique_id') }}" />
					</div>

					@component('partials.bootstrap.save-submit-button')
						{{ $tenancy->deposit ? 'Update Deposit' : 'Record Deposit' }}
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col">

				<div class="card mb-3">
					<h4 class="card-header">
						Record Deposit Payment
					</h4>
					<div class="card-body">

						@if ($tenancy->deposit)

							<form role="form" method="POST" action="{{ route('deposit.record-payment', $tenancy->deposit->id) }}">
								{{ csrf_field() }}

								<div class="form-group">
									<label for="created_at">Date</label>
									<input type="date" name="created_at" class="form-control">
								</div>

								<div class="form-group">
									<label for="amount">Amount</label>
									<input type="number" step="any" name="amount" class="form-control">
								</div>

								<div class="form-group">
									<label for="payment_method_id">Payment Method</label>
									<select name="payment_method_id" class="form-control">
										@foreach (payment_methods() as $method)
											<option value="{{ $method->id }}">{{ $method->name }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label for="note">Note</label>
									<textarea name="note" class="form-control" rows="4"></textarea>
								</div>

								<div class="form-group">
									<label class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" value="true" name="record_into_rent">
										<span class="custom-control-indicator"></span>
										<span class="custom-control-description">
											Do you want to record a positive amount into this tenancy rent account? eg. when transferring rent from the held deposit.
										</span>
									</label>
								</div>

								@component('partials.bootstrap.save-submit-button')
									Record Payment
								@endcomponent
							</form>

						@endif

					</div>
				</div>

			</div>
			<div class="col">

				@if ($tenancy->deposit)

					<div class="card mb-3">
						<h4 class="card-header">
							Certificate
						</h4>
						<div class="card-body">

						</div>
					</div>

					<div class="card mb-3">
						<h4 class="card-header">
							Deposit Payments
						</h4>
						<table class="table table-striped table-responsive">
							<thead>
								<th>Date</th>
								<th>Amount</th>
								<th>Method</th>
							</thead>
							<tbody>
								@foreach ($tenancy->deposit->payments as $payment)
									<tr>
										<td>{{ date_formatted($payment->created_at) }}</td>
										<td>{{ currency($payment->amount) }}</td>
										<td>{{ $payment->method->name }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

				@endif

			</div>
		</div>

	@endcomponent

@endsection