<table class="table table-striped table-responsive">
	<thead>
		<th>Name</th>
		<th>Next Number</th>
		<th>Unpaid</th>
		<th>Total</th>
		<th>Format</th>
	</thead>
	<tbody>
		@foreach ($invoice_groups as $group)
			<tr>
				<td>
					<a href="{{ route('invoice-groups.show', $group->id) }}" title="{{ $group->name}} ">
						{{ $group->name }}
					</a>
				</td>
				<td>{{ $group->next_number }}</td>
				<td>{{ count($group->unpaidInvoices) }}</td>
				<td>{{ currency($group->invoices->sum('total')) }}</td>
				<td>{{ $group->format }}</td>
			</tr>
		@endforeach
	</tbody>
</table>