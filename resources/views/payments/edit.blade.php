@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">

			@include('payments.partials.return-buttons')

			@component('partials.return-button')
				Payments
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

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form role="form" method="POST" action="{{ route('payments.update', $payment->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Payment Details
						@endslot
						@slot('body')

							@component('partials.form-group')
								@slot('label')
									Date
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" name="created_at" id="create_id" class="form-control" value="{{ $payment->present()->dateInput('created_at') }}" />
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
									<input type="number" name="amount" id="amount" step="any" class="form-control" value="{{ $payment->amount }}">
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
										<option @if ($payment->users->contains($user->id)) selected @endif value="{{ $user->id }}">
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
						Destroy Payment
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('payments.destroy', $payment->id) }}">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}

							<p class="card-text">
								To confirm you wish to destroy this payment please enter <b>{{ $payment->id }}</b> into the field below.
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