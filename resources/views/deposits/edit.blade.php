@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				@slot('url')
					{{ route('deposit.show', $deposit->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Deposit #{{ $deposit->id }}
		@endcomponent

		@component('partials.sub-header')
			Edit Deposit
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Deposit Details
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('deposits.update', $deposit->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="amount">Deposit Amount</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-money-bill"></i>
									</span>
									<input type="number" step="any" name="amount" id="amount" value="{{ $deposit->amount }}" class="form-control" />
								</div>
							</div>							

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

			</div>
			<div class="col-12 col-lg-6">

				@if ($deposit->deleted_at)

					<div class="card mb-3">
						@component('partials.card-header')
							Restore Deposit
						@endcomponent
						<div class="card-body">

							<form method="POST" action="{{ route('deposits.restore', $deposit->id) }}">
								{{ csrf_field() }}
								{{ method_field('PUT') }}

								@component('partials.save-button')
									Restore Deposit
								@endcomponent

							</form>

						</div>
					</div>

					<div class="card mb-3">
						@component('partials.card-header')
							Destroy Deposit
						@endcomponent
						<div class="card-body">

							<form method="POST" action="{{ route('deposits.forceDestroy', $deposit->id) }}">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}

								@component('partials.alerts.warning')
									Destroying a deposit will also destroy all of it's payments.
								@endcomponent

								@component('partials.save-button')
									Destroy Deposit
								@endcomponent

							</form>

						</div>
					</div>

				@else

					<div class="card mb-3">
						@component('partials.card-header')
							Delete Deposit
						@endcomponent
						<div class="card-body">

							<form method="POST" action="{{ route('deposits.destroy', $deposit->id) }}">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}

								@component('partials.save-button')
									Delete Deposit
								@endcomponent

							</form>

						</div>
					</div>

				@endif

			</div>
		</div>

	@endcomponent

@endsection