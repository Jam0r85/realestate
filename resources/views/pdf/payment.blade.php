@extends('pdf._layout')

@section('content')


		
			<h1 class="title">
				Receipt #{{ $payment->id }}
			</h1>
			<h2 class="subtitle">
				{{ date_formatted($payment->created_at) }}
			</h2>


			<table class="table is-striped is-bordered">
				<tr>
					<th class="text-center">Property</th>
				</tr>
				<tr>
					<td class="text-center">{{ $payment->present()->propertyName }}</td>
				</tr>
				<tr>
					<th class="text-center">Date Recorded</th>
				</tr>
				<tr>
					<td class="text-center">{{ datetime_formatted($payment->created_at) }}</td>
				</tr>
				<tr>
					<th class="text-center">Amount</th>
				</tr>
				<tr>
					<td class="text-center">{{ currency($payment->amount) }}</td>
				</tr>
				<tr>
					<th class="text-center">Payment Method</th>
				</tr>
				<tr>
					<td class="text-center">{{ $payment->method->name }}</td>
				</tr>
			</table>


@endsection