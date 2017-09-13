@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-primary float-right">
					Return
				</a>	
				<h1>Invoice #{{ $invoice->number }}</h1>
				<h3>Record a Payment</h3>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('invoices.create-payment', $invoice->id) }}">
				{{ csrf_field() }}

				@include('invoices.partials.payment-form')

				@component('partials.bootstrap.save-submit-button')
					Record Payment
				@endcomponent

			</form>

		</div>
	</section>

@endsection