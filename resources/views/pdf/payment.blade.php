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
					{{ date_formatted($payment->created_at) }}
				</h5>
			</div>

			<hr />

			<div class="lead">
				<p>Property - {{ $payment->present()->propertyName }}</p>
				<p>Tenancy - {{ $payment->present()->tenancyName }}</p>
				<p>Method - {{ $payment->method->name }}</p>
				<p>Recorded By - {{ $payment->owner->present()->fullName }}</p>
				<p><b>Amount - {{ currency($payment->amount) }}</b></p>
			</div>

			<hr />

			<p class="lead">
				Thanks,<br />
				<b>{{ get_setting('company_name', config('app.name')) }}</b>
			</p>

		</div>
	</div>

@endsection