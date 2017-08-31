<table class="table is-striped is-fullwidth">
	<thead>
		<th>Date</th>
		<th>Amount</th>
		<th>Method</th>
		@if (isset($show_tenancy))
			<th>Tenancy</th>
		@endif
		<th>Users</th>
		<th>Receipt</th>
	</thead>
	<tbody>
		@foreach ($payments as $payment)
			<tr>
				<td>
					<a href="{{ route('payments.show', $payment->id) }}">
						{{ date_formatted($payment->created_at) }}
					</a>
				</td>
				<td>{{ currency($payment->amount) }}</td>
				<td>{{ $payment->method->name }}</td>
				@if (isset($show_tenancy))
					<td>
						<a href="{{ route('tenancies.show', $payment->parent_id) }}">
							{{ $payment->parent->name }}
						</a>
					</td>
				@endif
				<td>
					@foreach ($payment->users as $user)
						<a href="{{ route('users.show', $user->id) }}">
							<span class="tag is-primary">
								{{ $user->name }}
							</span>
						</a>
					@endforeach
				</td>
				<td>
					<a href="{{ route('downloads.payment', $payment->id) }}" target="_blank">
						View
					</a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('partials.pagination', ['collection' => $payments])