@extends('pdf._layout')
@section('content')

	<div class="container">
		<div class="content">

			<h1 class="mb-0">
				Receipt #{{ $payment->id }}
			</h1>

			<h2 class="text-muted">
				{{ date_formatted($payment->created_at) }}
			</h2>

			<hr />

			<div class="lead">
				<p>Property - {{ $payment->present()->propertyName }}</p>
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