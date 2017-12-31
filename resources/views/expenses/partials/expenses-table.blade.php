@if (count($expenses))

	@component('partials.table')
		@slot('header')
			<th>Status</th>
			<th>Date</th>
			<th>Name</th>
			<th>Property</th>
			<th>Contractors</th>
			<th>Cost</th>
			<th class="text-right"></th>
		@endslot
		@slot('body')
			@foreach ($expenses as $expense)
				<tr>
					<td>{{ $expense->present()->status }}</td>
					<td>{{ date_formatted($expense->created_at) }}</td>
					<td>{!! truncate($expense->name) !!}</td>
					<td>
						<a href="{{ route('properties.show', $expense->property->id) }}">
							{{ truncate($expense->property->present()->shortAddress) }}
						</a>
					</td>
					<td>{!! $expense->present()->contractorBadge !!}</td>
					<td>{{ currency($expense->cost) }}</td>
					<td class="text-right">
						<a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-primary btn-sm">
							View
						</a>
						@foreach ($expense->documents as $document)
							<a href="{{ Storage::url($document->path) }}" target="_blank" class="btn btn-secondary btn-sm">
								@icon('download')
							</a>
						@endforeach
					</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent

@else

	@component('partials.alerts.warning')
		No expenses found.
	@endcomponent
@endif