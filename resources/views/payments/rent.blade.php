@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Rent Payments
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

		<ul class="nav nav-pills">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ request('method') ? slug_to_name(request('method')) : 'Method' }}
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item @if (!request('method')) active @endif" href="{{ Filter::link('rent-payments.index', ['method' => null]) }}">
						All Methods
					</a>
					<div class="dropdown-divider"></div>
					@foreach (payment_methods() as $method)
						<a class="dropdown-item @if (request('method') == $method->slug) active @endif" href="{{ Filter::link('rent-payments.index', ['method' => $method->slug]) }}">
							{{ $method->name }}
						</a>
					@endforeach
				</div>
			</li>
		</ul>

		@component('partials.table')
			@slot('header')
				<th>Date</th>
				<th>Tenancy</th>
				<th>Property</th>
				<th>Amount</th>
				<th>Method</th>
				<th class="text-right"></th>
			@endslot
			@slot('body')
				@foreach ($payments as $payment)
					<tr>
						<td>{{ date_formatted($payment->created_at) }}</td>
						<td>{{ truncate($payment->present()->tenancyName) }}</td>
						<td>{{ truncate($payment->present()->propertyNameShort) }}</td>
						<td>{{ currency($payment->amount) }}</td>
						<td>{{ $payment->method->name }}</td>
						<td class="text-right">
							<a href="{{ route('payments.show', $payment->id) }}" class="btn btn-primary btn-sm">
								View
							</a>
							<a href="{{ route('downloads.payment', $payment->id) }}" target="_blank" class="btn btn-info btn-sm">
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