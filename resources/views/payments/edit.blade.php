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

				@can('update', $payment)
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
										<input type="number" name="amount" id="amount" step="any" class="form-control" value="{{ pence_to_pounds($payment->amount) }}">
									@endcomponent
								@endcomponent

								@component('partials.form-group')
									@slot('label')
										Method
									@endslot
									<select name="payment_method_id" id="payment_method_id" class="form-control">
										@foreach (common('payment-methods') as $method)
											<option 
												@if ($payment->payment_method_id == $method->id) selected @endif 
												value="{{ $method->id }}">
													{{ $method->name }}
											</option>
										@endforeach
									</select>
								@endcomponent

								@component('partials.form-group')
									@slot('label')
										Users
									@endslot
									<select name="users[]" id="users" class="form-control select2" multiple>
										@foreach (common('users') as $user)
											<option @if ($payment->users->contains($user->id)) selected @endif value="{{ $user->id }}">
												{{ $user->present()->fullName }}
											</option>
										@endforeach
									</select>
								@endcomponent

							@endslot
							@slot('footer')
								@component('partials.save-button')
									Save Changes
								@endcomponent
							@endslot
						@endcomponent

					</form>
				@else
					@include('partials.errors.insufficient-permissions')
				@endif

			</div>
			<div class="col-12 col-lg-6">

				@can('delete', $payment)
					<form method="POST" action="{{ route('payments.delete', $payment->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						@component('partials.card')
							@slot('header')
								Destroy Payment
							@endslot
							@slot('body')
								@component('partials.alerts.danger')
									@icon('warning') This action cannot be undone.
								@endcomponent
							@endslot
							@slot('footer')
								@include('partials.forms.destroy-button')
							@endslot
						@endcomponent

					</form>
				@else
					@include('partials.errors.insufficient-permissions')
				@endif

			</div>
		</div>

	@endcomponent

@endsection