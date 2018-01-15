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

					<form method="POST" action="{{ route('statements.forceDestroy', $statement->id) }}">
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

					<div class="card mb-3">
						@component('partials.card-header')
							Delete Statement
						@endcomponent

						<div class="card-body">

							<form method="POST" action="{{ route('statements.destroy', $statement->id) }}">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}

								<p class="card-text">
									Are you sure you want to delete this statement?
								</p>

								<p class="card-text">
									Users attached to this statement will be unable to view it in their profile.
								</p>

								@component('partials.save-button')
									Delete Statement
								@endcomponent

							</form>

						</div>
					</div>

				@endif

			</div>
		</div>

	@endcomponent

@endsection