@component('partials.table')
	@slot('header')
		<th>Name</th>
		<th>Property</th>
		<th>Contractors</th>
		<th>Cost</th>
		<th>Paid</th>
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
					<a href="{{ route('properties.show', $expense->property->id) }}" title="{{ $expense->property->short_name }}">
						{!! truncate($expense->property->short_name) !!}
					</a>
				</td>
				<td>{{ $expense->contractor ? $expense->contractor->name : '' }}</td>
				<td>{{ currency($expense->cost) }}</td>
				<td>{{ date_formatted($expense->paid_at) }}</td>
				<td>
					@if (count($expense->documents))
						<i class="fa fa-check"></i>
					@endif
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent