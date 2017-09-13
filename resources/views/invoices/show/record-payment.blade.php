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

			<div class="row">
				<div class="col col-8">

					@include('partials.errors-block')

					<form role="form" method="POST" action="{{ route('invoices.create-payment', $invoice->id) }}">
						{{ csrf_field() }}

						@include('invoices.partials.payment-form')

						@component('partials.bootstrap.save-submit-button')
							Record Payment
						@endcomponent

					</form>

				</div>
				<div class="col">

					<div class="card mb-3">
						<div class="card-header">
							Invoice Details
						</div>
						<ul class="list-group list-group-flush">
							@component('partials.bootstrap.list-group-item')
								{{ currency($invoice->total) }}
								@slot('title')
									Invoice Total
								@endslot
							@endcomponent
							@component('partials.bootstrap.list-group-item')
								{{ currency($invoice->balance_total) }}
								@slot('title')
									Balance Remaining
								@endslot
							@endcomponent
						</ul>
					</div>
				</div>
			</div>

		</div>
	</section>

@endsection