@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			{{ $title }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		{{-- Payments Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('rent-payments.search') }}
			@endslot
			@if (session('rent_payments_search_term'))
				@slot('search_term')
					{{ session('rent_payments_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Payments Search --}}

		@component('partials.table')
			@slot('header')
				<th>Date</th>
				<th>Tenancy</th>
				<th>Amount</th>
				<th>Method</th>
				<th>Users</th>
				<th class="text-right"></th>
			@endslot
			@slot('body')
				@foreach ($payments as $payment)
					<tr>
						<td>{{ date_formatted($payment->created_at) }}</td>
						<td>
							<a href="{{ route('tenancies.show', $payment->parent_id) }}">
								{{ $payment->present()->tenancyName }}
							</a>
						</td>
						<td>{{ currency($payment->amount) }}</td>
						<td>{{ $payment->method->name }}</td>
						<td>
							@include('partials.bootstrap.users-inline', ['users' => $payment->users])
						</td>
						<td class="text-right">
							<a href="{{ route('payments.show', $payment->id) }}" class="btn btn-warning btn-sm">
								View
							</a>
							<a href="{{ route('downloads.payment', $payment->id) }}" target="_blank" class="btn btn-primary btn-sm">
								Receipt
							</a>
						</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

		@include('partials.pagination', ['collection' => $payments])

	@endcomponent

@endsection