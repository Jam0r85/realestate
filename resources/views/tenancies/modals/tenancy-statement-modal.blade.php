<div class="modal fade" id="tenancyStatementModal" tabindex="-1" role="dialog" aria-labelledby="tenancyStatementModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form role="form" method="POST" action="{{ route('statements.store') }}">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="tenancyStatementModalLabel">Create New Rental Statement</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<input type="hidden" name="tenancy_id" value="{{ $tenancy->id }}" />

					<div class="form-group">
						<label for="amount">Statement Amount (optional)</label>
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-gbp"></i>
							</span>
							<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" />
						</div>
						<small class="form-text text-muted">
							Leave this blank to use the current rent amount of {{ currency($tenancy->currentRent->amount) }}
						</small>
					</div>

					<div class="form-group">
						<label for="period_start">Start Date (optional)</label>
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="date" name="period_start" id="period_start" class="form-control" value="{{ $tenancy->next_statement_start_date ? $tenancy->next_statement_start_date->format('Y-m-d') : '' }}" />
						</div>
						<small class="form-text text-muted">
							Leave blank to automatically use the next statement date. ({{ date_formatted($tenancy->nextStatementDate()) }})
						</small>
					</div>

					<div class="form-group">
						<label for="period_end">End Date (optional)</label>
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="date" name="period_end" id="period_end" class="form-control" value="{{ old('period_end') }}" />
						</div>
						<small class="form-text text-muted">
							Leave blank to use the default time frame eg. one month
						</small>
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