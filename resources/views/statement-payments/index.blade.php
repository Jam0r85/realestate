@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>Statement Payments List</h1>
			</div>

		</div>
	</section>

	@if (count($unsent_payments))
		<section class="section">
			<div class="container">
				<div class="page-title">
					<h3 class="text-danger">
						<a href="{{ route('statement-payments.download') }}" target="_blank" class="btn btn-secondary float-right">
							<i class="fa fa-download"></i> Download
						</a>
						Unsent Payments
					</h3>
				</div>
				<div class="row">
					<div class="col">

						<form role="form" method="POST" action="{{ route('statement-payments.mark-sent') }}">
							{{ csrf_field() }}

							@include('partials.errors-block')

							@foreach ($unsent_payments as $name => $payments)

								<div class="card mb-3">
									<div class="card-header">
										{{ ucwords($name) }} {{ currency($payments->sum('amount')) }}
									</div>

									@include('statement-payments.partials.'.$name.'-table')
								</div>

							@endforeach

							<button type="submit" class="btn btn-primary">
								<i class="fa fa-check"></i> Mark as Sent
							</button>

						</form>

					</div>
				</div>
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