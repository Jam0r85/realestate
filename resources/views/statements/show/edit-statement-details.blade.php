@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				@slot('url')
					{{ route('statements.show', $statement->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Statement #{{ $statement->id }}
		@endcomponent

		@component('partials.sub-header')
			Update statement details
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Statement Details
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('statements.update', $statement->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="created_at">Created</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="date" name="created_at" id="created_at" class="form-control" value="{{ $statement->created_at->format('Y-m-d') }}" />
								</div>
							</div>

							<div class="form-group">
								<label for="period_start">Date From</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="date" name="period_start" id="period_start" class="form-control" value="{{ $statement->period_start->format('Y-m-d') }}" />
								</div>
							</div>

							<div class="form-group">
								<label for="period_end">Date End</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="date" name="period_end" id="period_end" class="form-control" value="{{ $statement->period_end->format('Y-m-d') }}" />
								</div>
							</div>

							<div class="form-group">
								<label for="amount">Statement Amount</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-money-bill"></i>
									</span>
									<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ $statement->amount }}" />
								</div>
							</div>

							<div class="form-group">
								<label for="send_by">Send Method</label>
								<select name="send_by" id="send_by" class="form-control">
									<option @if ($statement->send_by == 'email') selected @endif value="email">E-Mail</option>
									<option @if ($statement->send_by == 'post') selected @endif  value="post">Post</option>
								</select>
							</div>

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

			</div>
			<div class="col-12 col-lg-6">

				<div class="card mb-3">
					@component('partials.card-header')
						Delete Statement
					@endcomponent
					<div class="card-body">

						<form method="POST" action="{{ route('statements.destroy', $statement->id) }}">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}

							@component('partials.alerts.warning')
								<b>Warning</b>, this cannot be undone.
							@endcomponent

							<div class="form-group">
								@if (count($statement->payments))
									<div class="form-check">
										<label class="form-check-label">
											<input type="checkbox" name="paid_payments" id="paid_payments" value="true" class="form-check-input" />
											Delete paid statement payments?
										</label>
									</div>
									<div class="form-check">
										<label class="form-check-label">
											<input type="checkbox" name="unpaid_payments" id="unpaid_payments" value="true" class="form-check-input" checked />
											Delete unpaid statement payments?
										</label>
									</div>
								@endif

								@if ($statement->invoice())
									<div class="form-check">
										<label class="form-check-label">
											<input type="checkbox" name="invoice" id="invoice" value="true" class="form-check-input" checked />
											Delete the related invoice and it's items?
										</label>
									</div>
								@endif
							</div>

							@component('partials.save-button')
								Delete Statement
							@endcomponent

						</form>

					</div>
				</div>

			</div>
		</div>

	@endcomponent

@endsection