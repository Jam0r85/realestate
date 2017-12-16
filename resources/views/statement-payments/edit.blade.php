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

		@includeWhen($payment->sent_at, 'partials.alerts.success', ['slot' => 'This payment was sent on ' . date_formatted($payment->sent_at)])

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
								<label for="users">Attached Users</label>
								<select name="users[]" id="users" class="form-control select2" multiple>
									@foreach (users() as $user)
										<option @if ($payment->users->contains($user->id)) selected @endif value="{{ $user->id }}">
											{{ $user->present()->selectName }}
										</option>
									@endforeach
								</select>
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
						Destroy Statement Payment
					@endcomponent
					<div class="card-body">

						<form method="POST" action="{{ route('statement-payments.destroy', $payment->id) }}">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}

							@component('partials.save-button')
								Destroy Statement Payment
							@endcomponent

						</form>
					</div>
				</div>

			</div>
		</div>

	@endcomponent

@endsection 