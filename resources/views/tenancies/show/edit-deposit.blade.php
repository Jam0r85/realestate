@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('tenancies.show', $tenancy->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				{{ $tenancy->name }}
			@endcomponent

			@component('partials.sub-header')
				{{ $tenancy->deposit ? 'Manage the deposit' : 'Record a deposit ' }}
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col">

				<div class="card mb-3">

					@component('partials.bootstrap.card-header')
						Deposit Details
					@endcomponent

					<div class="card-body">

						@if ($tenancy->deposit)
							<form method="POST" action="{{ route('deposit.update', $tenancy->deposit->id) }}">
								{{ csrf_field() }}
								{{ method_field('PUT') }}
						@else
							<form method="POST" action="{{ route('deposit.store') }}">
								{{ csrf_field() }}
								<input type="hidden" name="tenancy_id" value="{{ $tenancy->id }}">
						@endif

							<div class="form-group">
								<label for="amount">Deposit Amount</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-gbp"></i>
									</span>
									<input type="number" step="any" name="amount" id="amount" class="form-control" required value="{{ $tenancy->deposit ? $tenancy->deposit->amount : old('amount') }}" />
								</div>
							</div>

							<div class="form-group">
								<label for="unique_id">Unique Reference</label>
								<input type="text" name="unique_id" id="unique_id" class="form-control" value="{{ $tenancy->deposit ? $tenancy->deposit->unique_id : old('unique_id') }}" />
								<small class="form-text text-muted">
									Enter the unique reference number for this deposit.
								</small>
							</div>

							@component('partials.save-button')
								{{ $tenancy->deposit ? 'Update Deposit' : 'Record Deposit' }}
							@endcomponent

						</form>

					</div>
				</div>

				@if ($tenancy->deposit)

					<div class="card mb-3">

						@component('partials.bootstrap.card-header')
							Certificate
						@endcomponent

						@if ($tenancy->deposit->certificate)

							<div class="card-body">

								<a href="{{ Storage::url($tenancy->deposit->certificate->path) }}" class="btn btn-block btn-success mb-2" target="_blank">
									<i class="fa fa-download"></i> Download Certificate
								</a>

								<form method="POST" action="{{ route('deposit.destroy-certificate', $tenancy->deposit->id) }}">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}

									<button type="submit" class="btn btn-block btn-danger">
										<i class="fa fa-trash"></i> Delete Certificate
									</button>
								</form>

							</div>

						@endif

						<div class="card-body">

							@if (!$tenancy->deposit->certificate)

								<div class="alert alert-warning">
									No certificate has been uploaded for this deposit.
								</div>

							@endif

							<form method="POST" action="{{ route('deposit.upload-certificate', $tenancy->deposit->id) }}" enctype="multipart/form-data">
								{{ csrf_field() }}

								<div class="form-group">
									<label for="certificate">{{ $tenancy->deposit->certificate ? 'Replace' : 'Upload' }} Certificate</label>
									<input type="file" class="form-control-file" id="certificate" name="certificate" required>
								</div>

								@component('partials.save-button')
									{{ $tenancy->deposit->certificate ? 'Replace' : 'Upload' }} Certificate
								@endcomponent

							</form>

						</div>
					</div>

					<div class="card mb-3">

						@component('partials.bootstrap.card-header')
							System Information
						@endcomponent

						<ul class="list-group list-group-flush">
							@component('partials.bootstrap.list-group-item')
								{{ $tenancy->property->branch->name }}
								@slot('title')
									Registered Branch
								@endslot
							@endcomponent
							@component('partials.bootstrap.list-group-item')
								{{ $tenancy->deposit->owner->name }}
								@slot('title')
									Created By
								@endslot
							@endcomponent
							@component('partials.bootstrap.list-group-item')
								{{ datetime_formatted($tenancy->deposit->created_at) }}
								@slot('title')
									Registered
								@endslot
							@endcomponent
							@component('partials.bootstrap.list-group-item')
								{{ datetime_formatted($tenancy->deposit->updated_at) }}
								@slot('title')
									Updated
								@endslot
							@endcomponent
						</ul>

					</div>

				@endif

			</div>

			@if ($tenancy->deposit)

			<div class="col-sm-12 col-lg-8">

				<div class="card mb-3">

					@component('partials.bootstrap.card-header')
						Deposit Payments
					@endcomponent

					<table class="table table-striped table-hover table-responsive">
						<thead>
							<th>Date</th>
							<th>Amount</th>
							<th>Method</th>
						</thead>
						<tbody>
							@foreach ($tenancy->deposit->payments as $payment)
								<tr>
									<td>{{ date_formatted($payment->created_at) }}</td>
									<td>{{ currency($payment->amount) }}</td>
									<td>{{ $payment->method->name }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="card mb-3">

					@component('partials.bootstrap.card-header')
						Record Deposit Payment
					@endcomponent

					<div class="card-body">

						@if ($tenancy->deposit->trashed())

							@component('partials.alerts.warning')
								This deposit has been archived, no payments can be recorded.
							@endcomponent

						@else

							<form method="POST" action="{{ route('deposit.record-payment', $tenancy->deposit->id) }}">
								{{ csrf_field() }}

								<div class="form-group">
									<label for="created_at">Date (optional)</label>
									<input type="date" name="created_at" class="form-control" />
									<small class="form-text text-muted">
										Leave blank to use the current date and time.
									</small>
								</div>

								<div class="form-group">
									<label for="amount">Amount</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
										<input type="number" step="any" name="amount" class="form-control" required />
									</div>
								</div>

								<div class="form-group">
									<label for="payment_method_id">Payment Method</label>
									<select name="payment_method_id" class="form-control" required />
										@foreach (payment_methods() as $method)
											<option value="{{ $method->id }}">{{ $method->name }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label for="note">Note (optional)</label>
									<textarea name="note" class="form-control" rows="4"></textarea>
								</div>

								@component('partials.save-button')
									Record Payment
								@endcomponent

							</form>

						@endif

					</div>
				</div>

			</div>

		@endif

	</div>

	@endcomponent

@endsection