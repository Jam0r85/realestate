@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('invoices.show', $invoice->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">Invoice #{{ $invoice->number }}</h1>
			<h2 class="subtitle">Record a Payment</h2>

			<hr />

			<form role="form" method="POST" action="{{ route('invoices.create-payment', $invoice->id) }}">
				{{ csrf_field() }}

				@include('invoices.partials.payment-form')

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Record Payment
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection