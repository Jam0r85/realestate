@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="card-columns">

				@if ($overdue_tenancies)
					<div class="card bg-danger text-white text-center mb-3">
						<div class="card-body">
							<h4 class="card-title">
								Overdue Tenancies!
							</h4>
							<p class="card-text">
								We have <b>{{ $overdue_tenancies }}</b> overdue {{ str_plural('tenancy', $overdue_tenancies) }}
							</p>
						</div>
						<div class="card-footer">
							<a href="{{ route('tenancies.overdue') }}" title="Overdue Tenancies List">
								View Overdue Tenancies
							</a>
						</div>
					</div>
				@endif

			</div>

		</div>
	</section>

@endsection