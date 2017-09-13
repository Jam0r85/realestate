@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="card-columns">

				@if ($overdue_tenancies)
					<div class="card bg-danger white-text mb-3">
						<div class="card-body text-center">
							<h4 class="card-title">
								Overdue Tenancies!
							</h4>
							<p class="card-text">
								We have {{ count($overdue_tenancies) }} overdue {{ str_plural('tenancy', count($overdue_tenancies)) }}
							</p>
						</div>
					</div>
				@endif

			</div>

		</div>
	</section>

@endsection