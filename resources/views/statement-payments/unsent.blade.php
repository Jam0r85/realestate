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

	@foreach ($groups as $name => $payments)

		@component('partials.sections.section-no-container')

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
									{{ $payment->parent->name }}
								@endif
							</div>	
							{{ $payment->statement->property->short_name }}					
						</td>
						<td>{{ currency($payment->amount) }}</td>
						<td></td>
					</tr>
				@endforeach
			@endcomponent

		@endcomponent

	@endforeach

@endsection