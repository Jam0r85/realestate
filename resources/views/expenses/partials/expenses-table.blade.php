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
		<th><i class="fa fa-upload"></i></th>
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
				<td>
					@if (count($expense->documents))
						<i class="fa fa-check"></i>
					@endif
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent