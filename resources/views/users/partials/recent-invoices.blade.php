<div class="card mb-2">
	<div class="card-content">

		<h3 class="title">Recent Invoices</h3>
		<h5 class="subtitle">The recent paid and unpaid invoices that this user is linked to.</h5>

		<table class="table is-striped is-fullwidth">
			<thead>
				<th>Number</th>
				<th>Amount</th>
				<th>Balance</th>
				<th>Date</th>
			</thead>
			<tbody>
				@foreach ($user->invoices()->limit(5)->get() as $invoice)
					<tr>
						<td><a href="{{ route('invoices.show', $invoice->id) }}">{{ $invoice->number }}</a></td>
						<td>{{ currency($invoice->total) }}</td>
						<td>{{ currency($invoice->total_balance) }}</td>
						<td>{{ date_formatted($invoice->created_at) }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

	</div>
	<footer class="card-footer">
		<a class="card-footer-item" href="{{ route('users.show', [$user->id, 'invoices']) }}">
			Invoices List
		</a>
	</footer>
</div>