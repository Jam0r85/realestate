@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			@component('partials.header')
				{{ $title }}
			@endcomponent

		</div>

		{{-- Payments Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('invoice-payments.search') }}
			@endslot
			@if (session('invoice_payments_search_term'))
				@slot('search_term')
					{{ session('invoice_payments_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Payments Search --}}

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<table class="table table-striped table-hover table-responsive">
			<thead>
				<th>Date</th>
				<th>Number</th>
				<th>Amount</th>
				<th>Method</th>
				<th>Users</th>
			</thead>
			<tbody>
				@foreach ($payments as $payment)
					<tr>
						<td>
							<a href="{{ route('payments.show', $payment->id) }}" title="Payment #{{ $payment->id }}">
								{{ date_formatted($payment->created_at) }}
							</a>
						</td>
						<td>
							<a href="{{ route('invoices.show', $payment->parent->id) }}">
								{!! truncate($payment->parent->number) !!}
							</a>
						</td>
						<td>{{ currency($payment->amount) }}</td>
						<td>{{ $payment->method->name }}</td>
						<td>
							@include('partials.bootstrap.users-inline', ['users' => $payment->users])
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		@include('partials.pagination', ['collection' => $payments])

	@endcomponent

@endsection