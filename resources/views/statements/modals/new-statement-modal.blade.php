<div class="modal fade" id="newStatementModal" tabindex="-1" role="dialog" aria-labelledby="tenancyStatementModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<form method="POST" action="{{ route('statements.store') }}">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="tenancyStatementModalLabel">Create New Rental Statement</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="row">
						<div class="col-12 col-lg-6">

							<input type="hidden" name="tenancy_id" id="tenancy_id" value="{{ $tenancy->id }}" />

							@component('partials.form-group')
								@slot('label')
									Amount
								@endslot
								@slot('help')
									The amount of rent received for this statement.
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('money')
									@endslot
									<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ old('amount') ?? $tenancy->present()->rentAmountPlain }}" />
								@endcomponent
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Start Date
								@endslot
								@slot('help')
									The start date of this statement.
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" name="period_start" id="period_start" class="form-control" value="{{ old('period_start') ?? $tenancy->present()->nextStatementStartDate('Y-m-d') }}" />
								@endcomponent
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									End Date
								@endslot
								@slot('help')
									The end date of this statement. Leave blank to use the default time frame eg. one month
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" name="period_end" id="period_end" class="form-control" value="{{ old('period_end') }}" />
								@endcomponent
							@endcomponent

						</div>
						<div class="col-12 col-lg-6">

							@component('partials.alerts.info')
								<p>
									@icon('house') <b>Statement &amp; Invoice Address</b>
								</p>
								{!! $tenancy->getLandlordPropertyAddress() !!}
							@endcomponent

							@component('partials.card')
								@slot('body')
									<p class="card-text">
										Want to record an old statement instead?
									</p>
									<a href="{{ route('old-statements.create', $tenancy->id) }}" class="btn btn-secondary btn-block">
										Record Old Statement
									</a>
								@endslot
							@endcomponent

						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					@component('partials.save-button')
						Create Statement
					@endcomponent
				</div>
			</div>
		</form>
	</div>
</div>