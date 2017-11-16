@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Statement Payments List
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@if (count($unsent_payments)  && $sent_payments->currentPage() == 1)

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

		@endif

		@component('partials.header')
			Send Payments
		@endcomponent

		@component('partials.table')
			@slot('header')
				<th>Property</th>
				<th>Statement</th>
				<th>Name</th>
				<th>Method</th>
				<th>Amount</th>
				<th>Sent</th>
				<th></th>
			@endslot
			@slot('body')
				@foreach ($sent_payments as $payment)
					<tr>
						<td>{{ $payment->present()->propertyName }}</td>
						<td>
							<a href="{{ route('statements.show', $payment->statement->id) }}">
								{{ $payment->present()->statementName }}
							</a>
						</td>
						<td>{{ $payment->present()->name }}</td>
						<td>{{ $payment->present()->method }}</td>
						<td>{{ currency($payment->amount) }}</td>
						<td>{{ date_formatted($payment->sent_at) }}</td>
						<td class="text-right">
							<a href="{{ route('statement-payments.edit', $payment->id) }}" class="btn btn-primary btn-sm">
								Edit
							</a>
						</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

		@include('partials.pagination', ['collection' => $sent_payments])

	@endcomponent

@endsection