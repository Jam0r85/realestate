@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('tenancies.show', $tenancy->id) }}" class="btn btn-secondary float-right">
			Return
		</a>

		@component('partials.header')
			{{ $tenancy->name }}
		@endcomponent

		@component('partials.sub-header')
			Rent Amount
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-sm-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						New Rent Details
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('tenancy-rents.store') }}">
							{{ csrf_field() }}

							<input type="hidden" name="tenancy_id" value="{{ $tenancy->id }}">

							<div class="form-group">
								<label for="starts_at">Date</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="date" class="form-control" name="starts_at" id="starts_at" value="{{ old('starts_at') }}" required>
								</div>
								<small class="form-text text-muted">
									Enter the date that this rent amount should start from.
								</small>
							</div>

							<div class="form-group">
								<label for="amount">Amount</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-gbp"></i>
									</span>
									<input type="number" step="any" class="form-control" name="amount" id="amount" value="{{ old('amount') }}" required>
								</div>
								<small class="form-text text-muted">
									Enter the new rent amount.
								</small>
							</div>

							@component('partials.save-button')
								Save Rent
							@endcomponent

						</form>

					</div>
				</div>

			</div>
			<div class="col-sm-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Rent History
					@endcomponent

					@component('partials.table')
						@slot('header')
							<th>Date</th>
							<th>Amount</th>
							<th>Recorded By</th>
							<th>Status</th>
						@endslot
						@slot('body')
							@foreach ($tenancy->rents as $rent)
								<tr>
									<td>{{ date_formatted($rent->starts_at) }}</td>
									<td>{{ currency($rent->amount) }}</td>
									<td>{{ $rent->owner->name }}</td>
									<td>{{ $rent->getStatus() }}</td>
								</tr>
							@endforeach
						@endslot
					@endcomponent

				</div>

			</div>
		</div>

	@endcomponent

@endsection