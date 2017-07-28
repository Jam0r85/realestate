@extends('invoices.show.layout')

@section('sub-content')

	@component('partials.title')
		Payments
	@endcomponent

	@component('partials.sections.section-no-container')

		@component('partials.subtitle')
			Payment History
		@endcomponent

		@component('partials.table')
			@slot('head')
				<th>Amount</th>
				<th>Method</th>
				<th>When</th>
				<th>User(s)</th>
			@endslot
			@foreach ($invoice->payments as $payment)
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

	@component('partials.sections.section-no-container')

		@component('partials.subtitle')
			Record Payment
		@endcomponent

		@if (!$invoice->canTakePayments())

			@component('partials.notifications.primary')
				This invoice has been paid or has a balance of {{ currency(0) }}. You cannot record new payments for it.
			@endcomponent

		@else

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('invoices.create-payment', $invoice->id) }}">
				{{ csrf_field() }}

				@include('invoices.partials.payment-form')

				@component('partials.forms.buttons.primary')
					Record Payment
				@endcomponent

			</form>

		@endif

	@endcomponent

@endsection