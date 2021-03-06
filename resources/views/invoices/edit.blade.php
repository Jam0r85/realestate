@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@if (count($invoice->statements))
				@foreach ($invoice->statements as $statement)
					@component('partials.return-button')
						Statement #{{ $statement->id }}
						@slot('url')
							{{ route('statements.show', $statement->id) }}
						@endslot
					@endcomponent
				@endforeach
			@endif

			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('invoices.show', $invoice->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $invoice->present()->name }}
		@endcomponent

		@component('partials.sub-header')
			Edit the Invoice
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Invoice Details
						@endslot

						<div class="card-body">

							@component('partials.form-group')
								@slot('label')
									Property
								@endslot
								<select name="property_id" id="property_id" class="form-control select2">
									<option value="0">None</option>
									@foreach (properties() as $property)
										<option @if ($invoice->property_id == $property->id) selected @endif value="{{ $property->id }}">
											{{ $property->present()->selectName }}
										</option>
									@endforeach
								</select>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Date Created
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" class="form-control" name="created_at" value="{{ $invoice->present()->dateInput('created_at') }}" />
								@endcomponent
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Date Due
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" class="form-control" name="due_at" value="{{ $invoice->present()->dateInput('due_at') }}" />
								@endcomponent
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Number
								@endslot
								<input type="text" class="form-control" name="number" value="{{ $invoice->number }}" />
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Users
								@endslot
								@slot('help')
									The attached users can download this invoice when they login to their profile.
								@endslot
								<select name="users[]" class="form-control select2" multiple>
									@foreach (users() as $user)
										<option @if ($invoice->users->contains($user->id)) selected @endif value="{{ $user->id }}">
											{{ $user->present()->selectName }}
										</option>
									@endforeach
								</select>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Recipient
								@endslot
								<textarea name="recipient" id="recipient" class="form-control" rows="5">{{ $invoice->recipient }}</textarea>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Terms
								@endslot
								<textarea name="terms" class="form-control" rows="5">{{ $invoice->terms }}</textarea>
							@endcomponent

						</div>

						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot
					@endcomponent

				</form>

			</div>
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Invoice Sent
						@endslot
						<div class="card-body">

							@if (count($invoice->statements))
								@component('partials.alerts.info')
									Linked statement sent dates are:-
									<ul>
									@foreach ($invoice->statements as $statement)
										<li>
											{{ $statement->present()->name }}
											<em>{{ $statement->present()->dateSent('Not sent') }}</em>
										</li>
									@endforeach
									</ul>
								@endcomponent
							@endif

							@component('partials.form-group')
								@slot('label')
									Date Sent
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" name="sent_at" id="sent_at" value="{{ $invoice->present()->dateInput('sent_at', old('sent_at')) }}" class="form-control">
								@endcomponent
							@endcomponent

						</div>

						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot
					@endcomponent

				</form>

				<form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Invoice Paid
						@endslot

						<div class="card-body">

							@if (!$invoice->canBePaid())

								@component('partials.alerts.warning')
									@if ($invoice->hasOutstandingBalance())
										@icon('warning') Invoice has an outstanding balance of {{ $invoice->present()->money('balance') }} which must be cleared before it can be marked as paid.
									@else
										@if (! count($invoice->items))
											@icon('warning') Invoice has no items and so cannot have been paid.
										@endif
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
												<em>{{ $statement->present()->datePaid('Not paid') }}</em>
											</li>
										@endforeach
										</ul>
									@endcomponent
								@endif

								@component('partials.form-group')
									@slot('label')
										Date Paid
									@endslot
									@component('partials.input-group')
										@slot('icon')
											@icon('calendar')
										@endslot
										<input type="date" name="paid_at" id="paid_at" value="{{ $invoice->present()->dateInput('paid_at', old('paid_at')) }}" class="form-control">
									@endcomponent
								@endcomponent

							@endif

						</div>

						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot
					@endcomponent

				</form>

				@if ($invoice->deleted_at)

					<form method="POST" action="{{ route('invoices.restore', $invoice->id) }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}

						@component('partials.card')
							@slot('header')
								Restore Invoice
							@endslot
							@slot('footer')
								@include('partials.forms.restore-button')
							@endslot
						@endcomponent

					</form>

					<form method="POST" action="{{ route('invoices.forceDelete', $invoice->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						@component('partials.card')
							@slot('header')
								Destroy Invoice
							@endslot
							@slot('body')
								@component('partials.alerts.danger')
									@icon('warning') Destroying this invoice will delete it permenantly.
								@endcomponent
							@endslot
							@slot('footer')
								@include('partials.forms.destroy-button')
							@endslot
						@endcomponent

					</form>

				@else

					<form method="POST" action="{{ route('invoices.delete', $invoice->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						@component('partials.card')
							@slot('header')
								Delete Invoice
							@endslot
							@slot('footer')
								@include('partials.forms.delete-button')
							@endslot
						@endcomponent

					</form>

				@endif

			</div>
		</div>

	@endcomponent

@endsection