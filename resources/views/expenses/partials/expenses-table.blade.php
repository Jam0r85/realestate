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
		@slot('footer')
			<tr>
				<td colspan="5">Total</td>
				<td>{{ currency($expenses->sum('cost')) }}</td>
				<td></td>
			</tr>
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
							@include('partials.document-download-button', ['path' => $document->path])
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