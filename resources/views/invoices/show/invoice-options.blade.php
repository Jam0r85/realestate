@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				Invoice #{{ $invoice->number }}
			@endcomponent

			@component('partials.sub-header')
				Invoice options
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="card mb-3">

			@component('partials.card-header')
				Recurring Invoice
				@slot('small')
					Setup this invoice to recur as often as you want.
				@endslot
			@endcomponent

			<div class="card-body">

				@include('partials.errors-block')

				<form method="POST" action="{{ route('invoices.create-recurring', $invoice->id) }}">
					{{ csrf_field() }}

					<div class="form-group">
						<label for="next_invoice">Next Invoice Date</label>
						<input type="date" name="next_invoice" id="next_invoice" class="form-control" />
						<small class="form-text text-muted">
							Enter the date that you want the next invoice to be created.
						</small>
					</div>

					<div class="form-row">
						<div class="col">
							<div class="form-group">
								<label for="interval">Interval</label>
								<input type="number" step="any" name="interval" id="interval" class="form-control" />
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="interval_type">Interval Type</label>
								<select name="interval_type" id="interval_type" class="form-control">
									<option>Days</option>
									<option>Weekdays</option>
									<option>Weeks</option>
									<option>Months</option>
									<option>Years</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="ends_at">End Date (optional)</label>
						<input type="date" name="ends_at" id="ends_at" class="form-control" />
						<small class="form-text text-muted">
							Enter the date when you want to stop creating new invoices or leave blank to continue indefinately.
						</small>
					</div>

					@component('partials.save-button')
						Save Changes
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection