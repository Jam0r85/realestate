@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
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

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				@can('update', $statement)

					<form method="POST" action="{{ route('statements.update', $statement->id) }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}

						@component('partials.card')
							@slot('header')
								Statement Details
							@endslot
							@slot('body')

								@component('partials.form-group')
									@slot('label')
										Created
									@endslot
									@component('partials.input-group')
										@slot('icon')
											@icon('calendar')
										@endslot
										<input type="date" name="created_at" id="created_at" class="form-control" value="{{ $statement->present()->dateInput('created_at') }}" />
									@endcomponent
								@endcomponent

								@component('partials.form-group')
									@slot('label')
										Start Date
									@endslot
									@component('partials.input-group')
										@slot('icon')
											@icon('calendar')
										@endslot
										<input type="date" name="period_start" id="period_start" class="form-control" value="{{ $statement->present()->dateInput('period_start') }}" />
									@endcomponent
								@endcomponent

								@component('partials.form-group')
									@slot('label')
										End Date
									@endslot
									@component('partials.input-group')
										@slot('icon')
											@icon('calendar')
										@endslot
										<input type="date" name="period_end" id="period_end" class="form-control" value="{{ $statement->present()->dateInput('period_end') }}" />
									@endcomponent
								@endcomponent

								@component('partials.form-group')
									@slot('label')
										Amount
									@endslot
									@component('partials.input-group')
										@slot('icon')
											@icon('money')
										@endslot
										<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ pence_to_pounds($statement->amount) }}" />
									@endcomponent
								@endcomponent

								@component('partials.form-group')
									@slot('label')
										Send to Landlord
									@endslot
									<select name="send_by" id="send_by" class="form-control">
										<option @if ($statement->send_by == 'email') selected @endif value="email">E-Mail</option>
										<option @if ($statement->send_by == 'post') selected @endif  value="post">Post</option>
									</select>
								@endcomponent

							@endslot
							@slot('footer')
								@component('partials.save-button')
									Save Changes
								@endcomponent
							@endslot
						@endcomponent

					</form>
				@else
					@component('partials.card')
						@slot('header')
							Statement Details
						@endslot
						@slot('body')
							@include('partials.errors.insufficient-permissions')
						@endslot
					@endcomponent
				@endcan

			</div>
			<div class="col-12 col-lg-6">

				<div class="card mb-3">
					@component('partials.card-header')
						Statement Paid
					@endcomponent

					<div class="card-body">

						@if (count($statement->unsentPayments) || !count($statement->payments))

							@component('partials.alerts.warning')
								No payments have been created for this statement or it has unsent payments.
							@endcomponent

						@else

							<form method="POST" action="{{ route('statements.update', $statement->id) }}">
								{{ csrf_field() }}
								{{ method_field('PUT') }}

								<div class="form-group">
									<label for="paid_at">Date Paid</label>
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<input type="date" name="paid_at" id="paid_at" value="{{ $statement->paid_at ? $statement->paid_at->format('Y-m-d') : old('sent_at') }}" class="form-control">
									</div>
								</div>

								@component('partials.save-button')
									Save Changes
								@endcomponent

							</form>

						@endif

					</div>
				</div>

				<div class="card mb-3">
					@component('partials.card-header')
						Statement Sent
					@endcomponent

					<div class="card-body">

						@if ($statement->paid_at)

							@component('partials.alerts.info')

								<p>This statement has been paid and can be {{ $statement->sent_at ? 'Resent' : 'Sent' }} to the landlord(s).</p>

								<form method="POST" action="{{ route('statements.send', $statement->id) }}">
									{{ csrf_field() }}

									<button type="submit" class="btn btn-secondary btn-block">
										{{ $statement->sent_at ? 'Resend' : 'Send' }} Statement
									</button>
								</form>

							@endcomponent

						@endif

						<form method="POST" action="{{ route('statements.update', $statement->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="sent_at">Date Sent</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="date" name="sent_at" id="sent_at" value="{{ $statement->sent_at ? $statement->sent_at->format('Y-m-d') : old('sent_at') }}" class="form-control">
								</div>
							</div>

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

				@if ($statement->deleted_at)

					@can('restore', $statement)
						<form method="POST" action="{{ route('statements.restore', $statement->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							@component('partials.card')
								@slot('header')
									Restore Statement
								@endslot
								@slot('footer')
									@include('partials.forms.restore-button')
								@endslot
							@endcomponent

						</form>
					@else
						@component('partials.card')
							@slot('header')
								Restore Statement
							@endslot
							@slot('body')
								@include('partials.errors.insufficient-permissions')
							@endslot
						@endcomponent
					@endcan

					<form method="POST" action="{{ route('statements.forceDelete', $statement->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						@component('partials.card')
							@slot('header')
								Destroy Statement
							@endslot
							@slot('body')
								@component('partials.alerts.warning')
									@icon('warning') Destroying this statement will delete it permenantly.
								@endcomponent
							@endslot
							@slot('footer')
								@include('partials.forms.destroy-button')
							@endslot
						@endcomponent

					</form>
					
				@else

					<form method="POST" action="{{ route('statements.delete', $statement->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						@component('partials.card')
							@slot('header')
								Delete Statement
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