@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('payments.show', $payment->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">Payment #{{ $payment->id }}</h1>
			<h2 class="subtitle">Edit payment details</h2>

			<hr />

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('payments.update', $payment->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<div class="field">
					<label class="label" for="created_at">Date Recorded</label>
					<div class="control">
						<input type="date" name="created_at" class="input" value="{{ $payment->created_at->format('Y-m-d') }}" />
					</div>
				</div>

				<div class="field">
					<label class="label" for="amount">Amount</label>
					<div class="control">
						<input type="number" name="amount" step="any" class="input" value="{{ $payment->amount }}">
					</div>
				</div>

				<div class="field">
					<label class="label" for="payment_method_id">Payment Method</label>
					<div class="control">
						<span class="select is-fullwidth">
							<select name="payment_method_id">
								@foreach (payment_methods() as $method)
									<option 
										@if ($payment->payment_method_id == $method->id) selected @endif 
										value="{{ $method->id }}">
											{{ $method->name }}
									</option>
								@endforeach
							</select>
						</span>
					</div>
				</div>

				<button type="submit" class="button is-primary">
					<span class="icon">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Save Changes
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection