@extends('statements.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Statement Payments Out
		@endcomponent

		@component('partials.table')
			@slot('head')
				<th>Name</th>
				<th>Method</th>
				<th>Amount</th>
				<th>Status</th>
			@endslot
			@foreach ($statement->payments as $payment)
				<tr>
					<td>{{ $payment->name_formatted }}</td>
					<td>{{ $payment->method_formatted }}</td>
					<td>{{ currency($payment->amount) }}</td>
					<td>
						@if ($payment->sent_at)
							Sent {{ datetime_formatted($payment->sent_at) }}
						@else
							Unsent
						@endif
					</td>
				</tr>
			@endforeach
		@endcomponent

	@endcomponent

	@component('partials.sections.section-no-container')

		@component('partials.subtitle')
			{{ count($statement->payments) ? 'Re-Generate' : 'Generate' }} Payments
		@endcomponent

		@if ($statement->paid_at || $statement->sent_at)
			@component('partials.notifications.primary')
				This statement has been paid in full. You cannot re-generate the payments.
			@endcomponent
		@else

			<div class="content">

				<p>
					Create the required payments to the landlord, business and contractors by clicking the button below.
				</p>

			</div>

			<hr />

			<form role="form" method="POST" action="{{ route('statements.create-payments', $statement->id) }}">
				{{ csrf_field() }}
				@component('partials.forms.buttons.primary')
					{{ count($statement->payments) ? 'Re-Generate' : 'Generate' }} Payments
				@endcomponent
			</form>

		@endif

	@endcomponent

@endsection