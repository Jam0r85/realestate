<div class="modal fade" id="tenancyNewRentAmountModal" tabindex="-1" role="dialog" aria-labelledby="tenancyNewRentAmountModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form role="form" method="POST" action="{{ route('tenancy-rents.store') }}">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="tenancyNewRentAmountModalLabel">New Rent Amount</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<input type="hidden" name="tenancy_id" value="{{ $tenancy->id }}">

					<div class="form-group">
						<label for="starts_at">Date</label>
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="date" class="form-control" name="starts_at" id="starts_at" value="{{ old('starts_at') ?? date('Y-m-d') }}" required>
						</div>
					</div>

					<div class="form-group">
						<label for="amount">Amount</label>
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-money-bill"></i>
							</span>
							<input type="number" step="any" class="form-control" name="amount" id="amount" value="{{ old('amount') }}" required>
						</div>
						<small class="form-text text-muted">
							Enter the new rent amount.
						</small>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					@component('partials.save-button')
						Save Amount
					@endcomponent
				</div>
			</div>
		</form>
	</div>
</div>