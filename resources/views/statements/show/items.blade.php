@if (count($statement->invoices))
	@component('partials.alerts.info')
		<p>This statement has the following invoices attached:</p>
		<ul>
			@foreach ($statement->invoices as $invoice)
				<li>
					<a href="{{ route('invoices.show', $invoice->id) }}">
						{{ $invoice->present()->name }}
					</a>
				</li>
			@endforeach
		</ul>
	@endcomponent
@endif

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

	@if (count($statement->expenses))

		@component('partials.table')
			@slot('header')
				<thead>
					<th>Name</th>
					<th>Contractor</th>
					<th>Expense Cost</th>
					<th>Amount</th>
				</thead>
			@endslot
			@slot('body')
				@foreach ($statement->expenses as $expense)
					<tr>
						<td>{{ $expense->name }}</td>
						<td>{{ $expense->present()->contractorName }}</td>
						<td>{{ currency($expense->cost) }}</td>
						<td>{{ currency($expense->pivot->amount) }}</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

	@else

		<div class="card-body">

			@component('partials.alerts.primary')
				This statement has no expense items attached to it.
			@endcomponent

		</div>

	@endif

</div>