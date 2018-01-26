<div class="modal fade" id="tenancyRentPaymentModal" tabindex="-1" role="dialog" aria-labelledby="tenancyRentPaymentModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form role="form" method="POST" action="{{ route('tenancies.create-rent-payment', $tenancy->id) }}">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="tenancyRentPaymentModalLabel">Record Rent Payment</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					@component('partials.form-group')
						@slot('label')
							Received
						@endslot
						@component('partials.input-group')
							@slot('icon')
								@icon('calendar')
							@endslot
							<input type="date" name="created_at" id="created_at" class="form-control" value="{{ old('created_at') ?? date('Y-m-d') }}" />
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
							<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ old('amount') ?? $tenancy->present()->pounds('rent') }}" />
						@endcomponent
					@endcomponent

					@component('partials.form-group')
						@slot('label')
							Method
						@endslot
						<select name="payment_method_id" id="payment_method_id" class="form-control" required>
							@foreach (payment_methods() as $method)
								<option value="{{ $method->id }}">{{ $method->name }}</option>
							@endforeach
						</select>
					@endcomponent

					@component('partials.form-group')
						@slot('label')
							Note
						@endslot
						<textarea name="note" id="note" class="form-control" rows="4"></textarea>
					@endcomponent

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					@component('partials.save-button')
						Record Payment
					@endcomponent
				</div>
			</div>
		</form>
	</div>
</div>