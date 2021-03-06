<div class="card mb-3">
	@component('partials.card-header')
		Invoice Items
	@endcomponent

	@if (count($statement->invoices))
	
		@foreach ($statement->invoices as $invoice)
			@include('invoice-items.partials.items-table', ['items' => $invoice->items])
		@endforeach

	@else

		<div class="card-body">

			@component('partials.alerts.info')
				This statement has no invoice attached.
			@endcomponent

		</div>

	@endif
</div>

<div class="card mb-3">
	@component('partials.card-header')
		Expense Items
	@endcomponent

	@component('partials.table')
		@slot('header')
			<th>Name</th>
			<th>Contractor</th>
			<th>Expense Cost</th>
			<th>Amount</th>
			<th></th>
		@endslot
		@slot('body')
			@foreach ($statement->expenses as $expense)
				<tr>
					<td>{{ $expense->name }}</td>
					<td>{{ $expense->present()->contractorName }}</td>
					<td>{{ money_formatted($expense->cost) }}</td>
					<td>{{ money_formatted($expense->pivot->amount) }}</td>
					<td class="text-right">
						<a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-primary btn-sm">
							View
						</a>
					</td>
				</tr>
			@endforeach
		@endslot
		@slot('footer')
			<tr>
				<td colspan="2">Total</td>
				<td>{{ money_formatted($statement->expenses->sum('cost')) }}</td>
				<td>{{ money_formatted($statement->expenses->sum('pivot.amount')) }}</td>
				<td></td>
			</tr>
		@endslot
	@endcomponent

</div>