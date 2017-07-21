@extends('tenancies.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Payments
		@endcomponent

		@component('partials.subtitle')
			Payments History
		@endcomponent

		@component('partials.table')
			@slot('head')
				<th>Amount</th>
				<th>Method</th>
				<th>When</th>
				<th>User(s)</th>
			@endslot
			@foreach ($tenancy->rent_payments as $payment)
				<tr>
					<td>{{ currency($payment->amount) }}</td>
					<td>{{ $payment->method->name }}</td>
					<td>{{ date_formatted($payment->created_at) }}</td>
					<td>
						@foreach ($payment->users as $user)
							<a href="{{ route('users.show', $user->id) }}">
								<span class="tag is-primary">
									{{ $user->name }}
								</span>
							</a>
						@endforeach
					</td>
				</tr>
			@endforeach
		@endcomponent

	@endcomponent

@endsection