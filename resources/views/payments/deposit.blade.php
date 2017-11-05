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
				{{ route('deposit-payments.search') }}
			@endslot
			@if (session('deposit_payments_search_term'))
				@slot('search_term')
					{{ session('deposit_payments_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Payments Search --}}

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@component('partials.table')
			@slot('header')
				<th>Date</th>
				<th>Tenancy</th>
				<th>Amount</th>
				<th>Method</th>
				<th>Users</th>
			@endslot
			@slot('body')
				@foreach ($payments as $payment)
					<tr>
						<td>
							<a href="{{ route('payments.show', $payment->id) }}" title="Payment #{{ $payment->id }}">
								{{ date_formatted($payment->created_at) }}
							</a>
						</td>
						<td>
							<a href="{{ route('tenancies.show', $payment->parent->tenancy->id) }}">
								{!! truncate($payment->parent->tenancy->name) !!}
							</a>
						</td>
						<td>{{ currency($payment->amount) }}</td>
						<td>{{ $payment->method->name }}</td>
						<td>
							@include('partials.bootstrap.users-inline', ['users' => $payment->users])
						</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

		@include('partials.pagination', ['collection' => $payments])

	@endcomponent

@endsection