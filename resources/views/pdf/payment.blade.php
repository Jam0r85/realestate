@extends('pdf._layout')
@section('content')

	<div class="container">
		<div class="content">

			<div class="section">
				<table>
					<tr>
						<td class="text-right">{!! $payment->present()->branchAddress !!}</td>
					</tr>
				</table>
			</div>

			<div class="section">
				<h2>
					Receipt #{{ $payment->id }}
				</h2>
				<h5>
					{{ $payment->present()->dateCreated }}
				</h5>
			</div>

			<hr />

			<div class="lead">

				@if ($payment->isRent())
					<p>Property - {{ $payment->parent->property->present()->fullAddress }}</p>
					<p>Tenancy - {{ $payment->parent->present()->name }}</p>
				@endif

				@if ($payment->isInvoice())
					<p>Invoice - {{ $payment->parent->present()->name }}</p>
					<p>Property - {{ $payment->parent->property->present()->fullAddress }}</p>
				@endif
				
				<p>Method - {{ $payment->method->name }}</p>
				<p>Recorded By - {{ $payment->owner->present()->fullName }}</p>
				<p><b>Amount - {{ $payment->present()->money('amount') }}</b></p>
			</div>

			<hr />

			<p class="lead">
				Thanks,<br />
				<b>{{ get_setting('company_name', config('app.name')) }}</b>
			</p>

		</div>
	</div>

@endsection