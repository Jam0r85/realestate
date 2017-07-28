@extends('pdf._layout')

@section('content')

	<section class="section has-header">
		<div class="container">
			<div class="heading has-text-right">

				@if (get_setting('company_logo'))	
					<img src="{{ get_file(get_setting('company_logo')) }}" class="header-image" />
				@else
					<h1>{{ get_setting('company_name') }}</h1>
				@endif 

			</div>
		</div>
	</section>

	{{-- Title --}}
	<section class="section">
		<div class="container">
			<h1 class="title">
				Receipt #{{ $payment->id }}
			</h1>
			<h2 class="subtitle">
				{{ date_formatted($payment->created_at) }}
			</h2>
		</div>
	</section>

	{{-- Items --}}
	<section class="section">
		<div class="container">
			<table class="table is-striped is-bordered">
				<tbody>
					@if (!$payment->isRent())
						<tr>
							<th class="text-center">For Invoice</th>
						</tr>
						<tr>
							<td class="text-center">{{ $payment->parent->number }}</td>
						</tr>
					@else
						<tr>
							<th class="text-center">Tenancy</th>
						</tr>
						<tr>
							<td class="text-center">{{ $payment->parent->name }}</td>
						</tr>
					@endif
					<tr>
						<th class="text-center">Property</th>
					</tr>
					<tr>
						<td class="text-center">{{ $payment->parent->property->name }}</td>
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
				</tbody>
			</table>
		</div>
	</section>

@endsection