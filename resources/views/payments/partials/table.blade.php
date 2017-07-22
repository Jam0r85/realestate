@component('partials.table')
	@slot('head')
		@if (isset($show_tenancy))
			<th>Tenancy</th>
		@endif
		<th>Amount</th>
		<th>Method</th>
		<th>When</th>
		<th>Receipt</th>
		<th>Users</th>
	@endslot
	@foreach ($payments as $payment)
		<tr>
			@if (isset($show_tenancy))
				<td>{{ $payment->parent->name }}</td>
			@endif
			<td>{{ currency($payment->amount) }}</td>
			<td>{{ $payment->method->name }}</td>
			<td>{{ date_formatted($payment->created_at) }}</td>
			<td><a href="{{ route('downloads.payment', $payment->id) }}" target="_blank">View</a></td>
			<td>
				@foreach ($payment->users as $user)
					<a href="{{ route('users.show', $user->id) }}">
						<span class="tag is-primary">
							{{ $user->name }}
						</span>
					</a>
				@endforeach
			</td>
		</tr>
	@endforeach
@endcomponent

@include('partials.pagination', ['collection' => $payments])