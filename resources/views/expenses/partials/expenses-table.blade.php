@if (count($expenses))
	@component('partials.table')
		@slot('header')
			<th>Name</th>
			<th>Property</th>
			<th>Contractors</th>
			<th>Cost</th>
			@if (request('paid') == false)
				<th>Balance</th>
			@endif
			<th class="text-right"></th>
		@endslot
		@slot('body')
			@foreach ($expenses as $expense)
				<tr>
					<td>{!! truncate($expense->name) !!}</td>
					<td>
						<a href="{{ route('properties.show', $expense->property->id) }}">
							{{ truncate($expense->property->present()->shortAddress) }}
						</a>
					</td>
					<td>{{ $expense->present()->contractorName }}</td>
					<td>{{ currency($expense->cost) }}</td>
					@if (request('paid') == false)
						<td>{{ currency($expense->present()->remainingBalance) }}</td>
					@endif
					<td class="text-right">
						<a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-primary btn-sm">
							View
						</a>
						{!! $expense->present()->invoiceDownloadButtons !!}
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