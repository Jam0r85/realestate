@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				@slot('url')
					{{ route('statement-payments.index') }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Statement Payment #{{ $payment->id }}
		@endcomponent

		@component('partials.sub-header')
			Edit Payment Details
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Payment Details
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('statement-payments.update', $payment->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="sent_at">Date Sent</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="date" name="sent_at" id="sent_at" class="form-control" value="{{ $payment->sent_at ? $payment->sent_at->format('Y-m-d') : '' }}" />
								</div>
								<small class="form-text text-muted">
									Leave blank to mark this payment as having not been sent.
								</small>
							</div>

							<div class="form-group">
								<label for="amount">Amount</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-money-bill"></i>
									</span>
									<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ $payment->amount }}" />
								</div>
							</div>

							<div class="form-group">
								<label for="bank_account_id">Bank Account</label>
								<select name="bank_account_id" id="bank_account_id" class="form-control">
									<option value="">None</option>
									@foreach (bank_accounts($payment->statement->tenancy->property->owners->pluck('id')->toArray()) as $account)
										<option @if ($payment->bank_account_id == $account->id) selected @endif value="{{ $account->id }}">
											{{ $account->present()->selectName }}
										</option>
									@endforeach
								</select>
								<small class="form-text text-muted">
									Select the bank account that this payment was sent to.
								</small>
							</div>

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

			</div>
			<div class="col-12 col-lg-6">

				<div class="card mb-3">
					@component('partials.card-header')
						Delete Payment
					@endcomponent
					<div class="card-body">

						<form method="POST" action="{{ route('statement-payments.destroy', $payment->id) }}">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}

							@component('partials.save-button')
								Delete Payment
							@endcomponent

						</form>
					</div>
				</div>

			</div>
		</div>

	@endcomponent

@endsection 