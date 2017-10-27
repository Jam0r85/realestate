@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('statement-payments.index') }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				Statement Payment {{ $payment->id }}
			@endcomponent

			@component('partials.sub-header')
				Edit payment details
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<form method="POST" action="{{ route('statement-payments.update', $payment->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="form-group">
				<label for="sent_at">Date Sent</label>
				<input type="date" name="sent_at" id="sent_at" class="form-control" value="{{ $payment->sent_at->format('Y-m-d') }}" />
			</div>

			@component('partials.save-button')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

@endsection 