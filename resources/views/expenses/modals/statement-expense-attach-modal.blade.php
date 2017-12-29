<div class="modal fade" id="statementExpenseAttachModal" tabindex="-1" role="dialog" aria-labelledby="statementExpenseAttachModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form role="form" method="POST" action="{{ route('statement-expense.store') }}">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newInvoiceItemModal">New Expense Item</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<input type="hidden" name="statement_id" id="statement_id" value="{{ $statement->id }}" />

					@component('partials.form-group')
						@slot('label')
							Expense
						@endslot
						<select name="expense_id" id="expense_id" class="form-control">
							@foreach ($statement->tenancy->property->unpaidExpenses as $expense)
								@if (!$statement->expenses->contains($expense->id))
									<option value="{{ $expense->id }}">
										{{ $expense->present()->selectName }}
									</option>
								@endif
							@endforeach
						</select>
					@endcomponent

					@component('partials.form-group')
						@slot('label')
							Amount
						@endslot
						@component('partials.input-group')
							@slot('icon')
								@lang('icons.money')
							@endslot
							<input type="number" step="any" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required />
						@endcomponent
					@endcomponent

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					@component('partials.save-button')
						Attach Item
					@endcomponent
				</div>
			</div>
		</form>
	</div>
</div>