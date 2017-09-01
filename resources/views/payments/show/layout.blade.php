@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">Payment #{{ $payment->id }}</h1>
			<h2 class="subtitle">
				@include('payments.partials.show-subtitle')
			</h2>

			<hr />

			<div class="columns">
				<div class="column is-4">

					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								Payment Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="is-muted">Amount</td>
								<td class="has-text-right">{{ currency($payment->amount) }}</td>
							</tr>
							<tr>
								<td class="is-muted">Method</td>
								<td class="has-text-right">{{ $payment->method->name }}</td>
							</tr>
						</table>
						<footer class="card-footer">
							<a class="card-footer-item" href="{{ Route('payments.show', [$payment->id, 'edit-details']) }}">
								Edit
							</a>
						</footer>
					</div>

					<div class="card mb-2">
						<header class="card-header">
							<p class="card-header-title">
								System Details
							</p>
						</header>
						<table class="table is-fullwidth is-striped">
							<tr>
								<td class="is-muted">Date Recorded</td>
								<td class="has-text-right">{{ date_formatted($payment->created_at) }}</td>
							</tr>
						</table>
					</div>

				</div>
			</div>

		</div>
	</section>

@endsection