<table class="table table-striped table-responsive">
	<thead>
		<th>Property</th>
		<th>Expense</th>
		<th class="text-right">Amount</th>
		<th>

		</th>
	</thead>
	<tbody>
		@foreach ($payments as $payment)
			<tr>
				<td>{{ $payment->statement->property->short_name }}</td>
				<td>
					{{ $payment->parent->name }}
					@if ($contractor = $payment->parent->contractor)
						<br />{{ $contractor->name }}
					@endif
				</td>
				<td class="text-right">{{ currency($payment->amount) }}</td>
				<td class="text-right">
					@include('statement-payments.partials.payment-checkbox')
				</td>
			</tr>
		@endforeach
	</tbody>
</table>