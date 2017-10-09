@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')
		<div class="page-title">
			<a href="{{ route('payments.show', $payment->id) }}" class="btn btn-secondary float-right">
				Return
			</a>
			<h1>Payment {{ $payment->id }}</h1>
			<h3>Edit payment details</h3>
		</div>
	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

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

			@component('partials.bootstrap.save-submit-button')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

@endsection