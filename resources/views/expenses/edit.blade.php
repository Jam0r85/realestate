@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('expenses.show', $expense->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $expense->name }}
		@endcomponent

		@component('partials.sub-header')
			Edit expense details
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<div class="card mb-3">
					@component('partials.card-header')
						Expense Details
					@endcomponent
					<div class="card-body">

						<form method="POST" action="{{ route('expenses.update', $expense->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							@include('expenses.partials.form')

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
						Expense Settings
					@endcomponent
					<div class="card-body">

						<form method="POST" action="{{ route('expenses.update', $expense->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							@component('partials.form-group')
								<div class="form-check">
									<label class="form-check-label">
										<input type="hidden" name="disable_paid_notification" value="no">
										<input class="form-check-input" type="checkbox" name="disable_paid_notification" value="yes" @if ($expense->getData('disable_paid_notification') == 'yes') checked @endif />
										Disable paid notification to the contractor?
									</label>
								</div>

								<div class="form-check">
									<label class="form-check-label">
										<input type="hidden" name="already_paid" value="no">
										<input class="form-check-input" type="checkbox" id="already_paid" name="already_paid" value="yes" @if ($expense->getData('already_paid') == 'yes') checked @endif />
										Has this expense been pre-paid?
									</label>
								</div>
							@endcomponent

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

				<div class="card mb-3">
					@component('partials.card-header')
						Destroy Expense
					@endcomponent
					<div class="card-body">

						@if ($expense->isPaid())

							@component('partials.alerts.warning')
								Expense has been paid and cannot be deleted.
							@endcomponent

						@else

							@if (count($expense->paymentsSent))

								@component('partials.alerts.warning')
									Expense has payments through statements and cannot be deleted.
								@endcomponent

							@else

								<form method="POST" action="{{ route('expenses.destroy', $expense->id) }}">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}

									@component('partials.save-button')
										Destroy Expense
									@endcomponent

								</form>

							@endif

						@endif

					</div>
				</div>

			</div>
		</div>

	@endcomponent

@endsection