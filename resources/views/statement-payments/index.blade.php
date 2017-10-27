@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			@component('partials.header')
				Statement Payments List
			@endcomponent

		</div>

	@endcomponent

	@if (count($unsent_payments)  && $sent_payments->currentPage() == 1)

		@component('partials.bootstrap.section-with-container')

			<form method="POST" action="{{ route('statement-payments.mark-sent') }}">
				{{ csrf_field() }}

				<div class="page-title">

					<div class="float-right">
						<a href="{{ route('statement-payments.print') }}" target="_blank" class="btn btn-secondary">
							<i class="fa fa-print"></i> Print
						</a>
						<button type="submit" class="btn btn-primary">
							<i class="fa fa-check"></i> Mark as Sent
						</button>
					</div>

					@component('partials.sub-header')
						Unsent Payments
					@endcomponent

				</div>

				@include('partials.errors-block')

				@foreach ($unsent_payments as $name => $payments)

					<div class="card mb-3">

						@component('partials.bootstrap.card-header')
							<b>{{ ucwords($name) }}</b> {{ currency($payments->sum('amount')) }}
						@endcomponent

						@include('statement-payments.partials.'.$name.'-table')
						
					</div>

				@endforeach

			</form>

		@endcomponent

	@endif

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			@component('partials.sub-header')
				Sent Payments
			@endcomponent

		</div>

		@include('statement-payments.partials.sent-payments-table', ['payments' => $sent_payments])

	@endcomponent

@endsection