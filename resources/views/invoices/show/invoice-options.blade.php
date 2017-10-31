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
				Clone Invoice
				@slot('small')
					Clone this invoice and it's items but with a new number.
				@endslot
			@endcomponent

			<div class="card-body">

				<form method="POST" action="{{ route('invoices.clone', $invoice->id) }}">
					{{ csrf_field() }}

					@component('partials.save-button')
						Clone Invoice
					@endcomponent

				</form>

			</div>
		</div>

		<div class="card mb-3">

			@component('partials.card-header')
				Recurring Invoice
				@slot('small')
					Setup this invoice to recur as often as you want.
				@endslot
			@endcomponent

			<div class="card-body">

				@if ($invoice->recur)

					<p class="card-text">
						This invoice was created automatically based on the recurring settings of <a href="{{ route('invoices.show', $invoice->recur->invoice->id) }}">Invoice {{ $invoice->recur->invoice->name }}</a>.
					</p>

					<a href="{{ route('invoices.show', [$invoice->recur->invoice->id, 'invoice-options']) }}" class="btn btn-primary">
						Edit Settings
					</a>

				@else

					@include('partials.errors-block')

					<form method="POST" action="{{ route('invoices.create-recurring', $invoice->id) }}">
						{{ csrf_field() }}

						<div class="form-group">
							<label for="next_invoice">Next Invoice Date</label>
							<input type="date" name="next_invoice" id="next_invoice" class="form-control" value="{{ $invoice->recurring ? $invoice->recurring->next_invoice->format('Y-m-d') : '' }}" />
							<small class="form-text text-muted">
								Enter the date that you want the next invoice to be created.
							</small>
						</div>

						<div class="form-row">
							<div class="col">
								<div class="form-group">
									<label for="interval">Interval</label>
									<input type="number" step="any" name="interval" id="interval" class="form-control" />
									<small class="form-text text-muted">
										Enter the numeric interval between invoices.
									</small>
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
									<small class="form-text text-muted">
										Select the interval type relating to the numeric interval.
									</small>
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

				@endif

			</div>

		</div>

	@endcomponent

@endsection