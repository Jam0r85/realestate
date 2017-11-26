@if (count($expenses))
	@component('partials.table')
		@slot('header')
			<th>Name</th>
			<th>Property</th>
			<th>Contractors</th>
			<th>Cost</th>
			@if (isset($unpaid))
				<th>Balance</th>
			@else
				<th>Paid</th>
			@endif
			<th>Invoice</th>
		@endslot
		@slot('body')
			@foreach ($expenses as $expense)
				<tr>
					<td>
						<a href="{{ route('expenses.show', $expense->id) }}" title="{{ $expense->name }}">
							{!! truncate($expense->name) !!}
						</a>
					</td>
					<td>
						<a href="{{ route('properties.show', $expense->property->id) }}">
							{{ $expense->property->present()->shortAddress }}
						</a>
					</td>
					<td>{{ $expense->present()->contractorName }}</td>
					<td>{{ currency($expense->cost) }}</td>
					@if (isset($unpaid))
						<td>{{ currency($expense->present()->remainingBalance) }}</td>
					@else
						<td>{{ date_formatted($expense->paid_at) }}</td>
					@endif
					<td>{!! $expense->present()->invoiceDownloadButtons !!}</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent
@else
	@component('partials.alerts.warning')
		No expenses found.
	@endcomponent
@endif