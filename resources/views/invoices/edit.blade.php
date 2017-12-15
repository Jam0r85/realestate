@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				@slot('url')
					{{ route('invoices.show', $invoice->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Invoice #{{ $invoice->number }}
		@endcomponent

		@component('partials.sub-header')
			Update the invoice details
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<div class="card mb-3">
					@component('partials.card-header')
						Invoice Details
					@endcomponent
					<div class="card-body">

						<form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="property_id">Property</label>
								<select name="property_id" id="property_id" class="form-control select2">
									@foreach (properties() as $property)
										<option @if ($invoice->property_id == $property->id) selected @endif value="{{ $property->id }}">
											{{ $property->present()->selectName }}
										</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label for="created_at">Date Created</label>
								<input type="date" class="form-control" name="created_at" value="{{ $invoice->created_at->format('Y-m-d') }}" />
							</div>

							<div class="form-group">
								<label for="due_at">Date Due</label>
								<input type="date" class="form-control" name="due_at" value="{{ $invoice->due_at ? $invoice->due_at->format('Y-m-d') : null }}" />
							</div>

							@if ($invoice->paid_at)
								<div class="form-group">
									<label for="paid_at">Date Paid</label>
									<input type="date" class="form-control" name="paid_at" value="{{ $invoice->paid_at->format('Y-m-d') }}" />
								</div>
							@endif

							<div class="form-group">
								<label for="number">Number</label>
								<input type="text" class="form-control" name="number" value="{{ $invoice->number }}" />
							</div>

							<div class="form-group">
								<label for="users">Users</label>
								<select name="users[]" class="form-control select2" multiple>
									@foreach (users() as $user)
										<option @if ($invoice->users->contains($user->id)) selected @endif value="{{ $user->id }}">
											{{ $user->present()->selectName }}
										</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label for="recipient">Recipient</label>
								<textarea @if ($invoice->statement) disabled @endif name="recipient" class="form-control" rows="5">{{ $invoice->recipient }}</textarea>
								@if ($invoice->statement)
									<small class="form-text text-danger">
										This invoice is attached to a rental statement and will inherit the rental statement's address.
									</small>
								@else
									<small class="form-text text-muted">
										Enter the recipient address for this invoice. If the invoice has users attached to it, their names will automatically be added above the address for you.
									</small>
								@endif
							</div>

							<div class="form-group">
								<label for="terms">Terms</label>
								<textarea name="terms" class="form-control" rows="5">{{ $invoice->terms }}</textarea>
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
						Invoice Sent
					@endcomponent
					<div class="card-body">

						@if (count($invoice->statements))
							@component('partials.alerts.info')
								Linked statement sent dates are:-
								<ul>
								@foreach ($invoice->statements as $statement)
									<li>
										{{ $statement->present()->name }}
										<em>{{ $statement->sent_at ? date_formatted($statement->sent_at) : 'Not sent' }}</em>
									</li>
								@endforeach
								</ul>
							@endcomponent
						@endif

						<form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="paid_at">Date Sent</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="date" name="sent_at" id="sent_at" value="{{ $invoice->sent_at ? $invoice->sent_at->format('Y-m-d') : old('sent_at') }}" class="form-control">
								</div>
							</div>

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

				<div class="card mb-3">
					@component('partials.card-header')
						Invoice Paid
					@endcomponent
					<div class="card-body">

						@if (!$invoice->noBalance())

							@component('partials.alerts.warning')
								@if ($invoice->balance > 0)
									Invoice has an outstanding balance of {{ currency($invoice->balance) }} which must be cleared before it can be marked as paid.
								@else
									Invoice has no items and so cannot have been paid.
								@endif
							@endcomponent

						@else

							@if (count($invoice->statements))
								@component('partials.alerts.info')
									Linked statement paid dates are:-
									<ul>
									@foreach ($invoice->statements as $statement)
										<li>
											{{ $statement->present()->name }}
											<em>{{ $statement->paid_at ? date_formatted($statement->paid_at) : 'Not paid' }}</em>
										</li>
									@endforeach
									</ul>
								@endcomponent
							@endif

							<form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
								{{ csrf_field() }}
								{{ method_field('PUT') }}

								<div class="form-group">
									<label for="paid_at">Date Paid</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<input type="date" name="paid_at" id="paid_at" value="{{ $invoice->paid_at ? $invoice->paid_at->format('Y-m-d') : old('paid_at') }}" class="form-control">
									</div>
								</div>

								@component('partials.save-button')
									Save Changes
								@endcomponent

							</form>

						@endif

					</div>
				</div>

				@if ($invoice->deleted_at)

					<div class="card mb-3">
						@component('partials.card-header')
							Restore Invoice
						@endcomponent
						<div class="card-body">

							<form method="POST" action="{{ route('invoices.restore', $invoice->id) }}">
								{{ csrf_field() }}
								{{ method_field('PUT') }}

								@component('partials.save-button')
									Restore Invoice
								@endcomponent

							</form>

						</div>
					</div>

					<div class="card mb-3">
						@component('partials.card-header')
							Destroy Invoice
						@endcomponent
						<div class="card-body">

							<form method="POST" action="{{ route('invoices.forceDestroy', $invoice->id) }}">
								{{ csrf_field() }}
								{{ method_field('PUT') }}

								@component('partials.save-button')
									Destroy Invoice
								@endcomponent

							</form>

						</div>
					</div>

				@else

					<div class="card mb-3">
						@component('partials.card-header')
							Delete Invoice
						@endcomponent
						<div class="card-body">

							<form method="POST" action="{{ route('invoices.destroy', $invoice->id) }}">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}

								@component('partials.save-button')
									Delete Invoice
								@endcomponent

							</form>

						</div>
					</div>

				@endif

			</div>
		</div>

	@endcomponent

@endsection