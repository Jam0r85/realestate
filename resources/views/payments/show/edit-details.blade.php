@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				@slot('url')
					{{ route('payments.show', $payment->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Payment #{{ $payment->id }}
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

						<form role="form" method="POST" action="{{ route('payments.update', $payment->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="created_at">Date Recorded</label>
								<input type="date" name="created_at" class="form-control" value="{{ $payment->created_at->format('Y-m-d') }}" />
							</div>

							<div class="form-group">
								<label for="amount">Amount</label>
								<input type="number" name="amount" step="any" class="form-control" value="{{ $payment->amount }}">
							</div>

							<div class="form-group">
								<label for="payment_method_id">Payment Method</label>
								<select name="payment_method_id" class="form-control">
									@foreach (payment_methods() as $method)
										<option 
											@if ($payment->payment_method_id == $method->id) selected @endif 
											value="{{ $method->id }}">
												{{ $method->name }}
										</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label for="users">Attached Users</label>
								<select name="users[]" id="users" class="form-control select2" multiple>
									@foreach (users() as $user)
										<option @if ($payment->parent->tenants->contains($user->id)) selected @endif value="{{ $user->id }}">
											{{ $user->present()->fullName }}
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
						Delete Payment
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('payments.destroy', $payment->id) }}">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}

							<p class="card-text">
								Enter the ID ({{ $payment->id }}) of this payment into the field below to confirm that you wish to destroy it.
							</p>

							<div class="form-group">
								<input type="text" name="confirmation" class="form-control" />
							</div>

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