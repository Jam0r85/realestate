@extends('statements.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Statement Payments List
		@endcomponent

		@component('partials.subtitle')
			Generated Payments
		@endcomponent

		@component('partials.table')
			@slot('head')
				<th>Name</th>
				<th>Method</th>
				<th>Amount</th>
				<th>Sent</th>
			@endslot
			@foreach ($statement->payments as $payment)
				<tr>
					<td>{{ $payment->name_formatted }}</td>
					<td>{{ $payment->method_formatted }}</td>
					<td>{{ currency($payment->amount) }}</td>
					<td>{{ datetime_formatted($payment->sent_at) }}</td>
				</tr>
			@endforeach
		@endcomponent

		@component('partials.subtitle')
			Generate Payments
		@endcomponent

		<form role="form" method="POST" action="{{ route('statements.create-payments', $statement->id) }}">
			{{ csrf_field() }}

			@component('partials.forms.buttons.primary')
				Generate
			@endcomponent

		</form>

	@endcomponent

@endsection