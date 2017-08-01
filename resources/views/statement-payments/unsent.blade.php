@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('statements.index') }}">Statements List</a></li>
	<li class="is-active"><a>Unsent Statement Payments</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			Unsent Payments
		@endslot
	@endcomponent

	@component('partials.sections.section')

		<form role="form" method="POST" action="{{ route('statement-payments.mark-sent') }}">
			{{ csrf_field() }}

			@include('partials.errors-block')

			@foreach ($groups as $name => $payments)

				@component('partials.subtitle')
					{{ $name }} {{ currency($payments->sum('amount')) }}
				@endcomponent

				@component('partials.table')
					@slot('head')
						<th width="100%">Name</th>
						<th>Amount</th>
						<th></th>
					@endslot
					@foreach ($payments as $payment)
						<tr>
							<td>
								<div class="is-pulled-right">
									@if ($name == '')								
										@if ($payment->bank_account)
											{{ $payment->bank_account->name }}
										@else
											Cheque or Cash
										@endif
									@elseif ($name == 'invoices')
										#{{ $payment->parent->number }}
									@elseif ($name == 'expenses')
										{!! $payment->parent->statement_name !!}
									@endif
								</div>	
								{{ $payment->statement->property->short_name }}					
							</td>
							<td>{{ currency($payment->amount) }}</td>
							<td>
								<input type="checkbox" name="payment_id[]" value="{{ $payment->id }}" />								
							</td>
						</tr>
					@endforeach
				@endcomponent

				<hr />

			@endforeach

			<button type="submit" class="button is-primary is-outlined">
				Mark as Sent
			</button>

		</form>

	@endcomponent

@endsection