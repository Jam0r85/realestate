@component('partials.table')
	@slot('head')
		<th>Name</th>
		<th>Next Number</th>
		<th>Format</th>
		<th>Actions</th>
	@endslot
	@foreach ($invoice_groups as $invoice_group_list)
		<tr>
			<td><a href="{{ route('invoice-groups.show', $invoice_group_list->id) }}">{{ $invoice_group_list->name }}</a></td>
			<td>{{ $invoice_group_list->next_number }}</td>
			<td>{{ $invoice_group_list->format }}</td>
			<td>
				<a href="{{ route('invoice-groups.edit', $invoice_group_list->id) }}">
					Edit Group
				</a>
			</td>
		</tr>
	@endforeach
@endcomponent