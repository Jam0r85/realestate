@component('partials.table')
	@slot('head')
		<th>Name</th>
		@if (isset($description))
			<th>Description</th>
		@endif
		<th>Contractors</th>
		<th>Cost</th>
		@if (isset($amount))
			<th>Amount</th>
		@endif
	@endslot
	@foreach ($expenses as $expense)
		<tr>
			<td>{{ $expense->name }}</td>
			@if (isset($description))
				<td>{{ $expense->description }}</td>
			@endif
			<td>
				@foreach ($expense->contractors as $user)
					<a href="{{ route('users.show', $user->id) }}">
						<span class="tag is-primary">
							{{ $user->name }}
						</span>
					</a>
				@endforeach
			</td>
			<td>{{ currency($expense->cost) }}</td>
			@if (isset($amount))
				<td>{{ currency($expense->pivot->amount) }}</td>
			@endif
		</tr>
	@endforeach
@endcomponent