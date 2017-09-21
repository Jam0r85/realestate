@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>Statement Payments List</h1>
			</div>

		</div>
	</section>

	@if (count($unsent_payments)  && $payments->currentPage() == 1)
		<section class="section">
			<div class="container">

				<form role="form" method="POST" action="{{ route('statement-payments.mark-sent') }}">
					{{ csrf_field() }}

					<div class="page-title">
						<h3 class="text-danger">
							<div class="float-right">
								<a href="{{ route('statement-payments.print') }}" target="_blank" class="btn btn-secondary">
									<i class="fa fa-print"></i> Print
								</a>
								<button type="submit" class="btn btn-primary">
									<i class="fa fa-check"></i> Mark as Sent
								</button>
							</div>
							Unsent Payments
						</h3>
					</div>
					<div class="row">
						<div class="col">

							@include('partials.errors-block')

							@foreach ($unsent_payments as $name => $payments)

								<div class="card mb-3">
									<div class="card-header">
										{{ ucwords($name) }} {{ currency($payments->sum('amount')) }}
									</div>

									@include('statement-payments.partials.'.$name.'-table')
								</div>

							@endforeach

						</div>
					</div>

				</form>

			</div>
		</section>
	@endif

	<section class="section">
		<div class="container">
			<div class="page-title">
				<h3 class="text-success">
					Sent Payments
				</h3>
			</div>
			<div class="row">
				<div class="col">
					@include('statement-payments.partials.sent-payments-table')
				</div>
			</div>
		</div>
	</section>

@endsection