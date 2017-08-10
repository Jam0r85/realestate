@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="title">Unsent Payments</h1>

			<hr />

			@if (!count($groups))

				<div class="notification">
					There are no outstanding unpaid payments.
				</div>

			@else

				<form role="form" method="POST" action="{{ route('statement-payments.mark-sent') }}">
					{{ csrf_field() }}

					@include('partials.errors-block')

					@foreach ($groups as $name => $payments)

						<div class="card mb-2">
							<header class="card-header">
								<p class="card-header-title">
									{{ ucwords($name) }} {{ currency($payments->sum('amount')) }}
								</p>
							</header>

							@include('statement-payments.partials.'.$name.'-table')
						</div>

					@endforeach

					<button type="submit" class="button is-primary">
						<span class="icon is-small">
							<i class="fa fa-check"></i>
						</span>
						<span>
							Mark as Sent
						</span>
					</button>

				</form>

			@endif

		</div>
	</section>

@endsection