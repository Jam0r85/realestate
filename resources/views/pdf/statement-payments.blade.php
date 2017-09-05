@extends('pdf._layout')

@section('content')

	<section class="section">
		<div class="container-fluid">

			@foreach ($unsent_payments as $name => $payments)

				<div class="card mb-3">
					<div class="card-header">
						<p class="card-header-title">
							{{ ucwords($name) }} {{ currency($payments->sum('amount')) }}
						</p>
					</div>

					@include('statement-payments.partials.'.$name.'-table')
				</div>

			@endforeach

		</div>
	</section>

@endsection