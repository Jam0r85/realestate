@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('statement-payments.index') }}" class="btn btn-secondary float-right">
			Return
		</a>

		@component('partials.header')
			Statement Payment #{{ $payment->id }}
		@endcomponent

		@component('partials.sub-header')
			Edit Payment Details
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

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

			@component('partials.save-button')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

@endsection 