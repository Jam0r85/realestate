@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Statement Payments List
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		@if (count($unsent_payments)  && $sent_payments->currentPage() == 1)

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

			@foreach ($unsent_payments as $name => $payments)

				<div class="card mb-3">

					@component('partials.bootstrap.card-header')
						<b>{{ ucwords($name) }}</b> {{ money_formatted($payments->sum('amount')) }}
					@endcomponent

					@include('statement-payments.partials.'.$name.'-table')
					
				</div>

			@endforeach

		@endif

		@include('statement-payments.partials.statement-payments-table', ['payments' => $sent_payments])

		@include('partials.pagination', ['collection' => $sent_payments])

	@endcomponent

@endsection