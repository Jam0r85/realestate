@extends('invoices.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')
		@slot('title')
			Payment Record
		@endslot

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
					<td></td>
				</tr>
			@endforeach
		@endcomponent

	@endcomponent

	<hr />

	@if ($invoice->paid_at || $invoice->total <= 0)

		<div class="notification is-primary">
			This invoice has been paid or has a balance of {{ currency(0) }}. You cannot record new payments for it.
		</div>

	@else

		@component('partials.sections.section-no-container')
			@slot('title')
				Record Payment
			@endslot

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('invoices.create-payment', $invoice->id) }}">
				{{ csrf_field() }}

				@include('invoices.partials.payment-form')

				<button type="submit" class="button is-primary is-outlined">
					Record Payment
				</button>

			</form>

		@endcomponent

	@endif

@endsection