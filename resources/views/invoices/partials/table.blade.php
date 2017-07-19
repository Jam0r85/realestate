@component('partials.table')
	@slot('head')
		<th>Number</th>
		<th>Date</th>
		@if (isset($property))
			<th>Property</th>
		@endif
		<th>Total</th>
		@if (isset($users))
			<th>Users</th>
		@endif
		<th>Invoice</th>
	@endslot
	@foreach ($invoices as $invoice)
		<tr>
			<td><a href="{{ route('invoices.show', $invoice->id) }}">{{ $invoice->number }}</a></td>
			<td>{{ date_formatted($invoice->created_at) }}</td>
			@if (isset($property))
				<td>{{ $invoice->property->short_name }}</td>
			@endif
			<td>{{ currency($invoice->total) }}</td>
			@if (isset($users))
				<td>
					@foreach ($invoice->users as $user)
						<a href="{{ route('users.show', $user->id) }}">
							<span class="tag is-primary">
								{{ $user->name }}
							</span>
						</a>
					@endforeach
				</td>
			@endif
			<td>
				<a href="#">
					Download
				</a>
			</td>
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $invoices])