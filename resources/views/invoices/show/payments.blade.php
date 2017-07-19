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

@endsection