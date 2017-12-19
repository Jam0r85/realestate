@component('partials.table')
		@slot('header')
			<th>Date</th>
			<th>Tenancy</th>
			<th>Property</th>
			<th>Amount</th>
			<th>Balance</th>
			<th>Ref</th>
			<th></th>
		@endslot
		@slot('body')
			@foreach ($deposits as $deposit)
				<tr>
					<td>{{ date_formatted($deposit->created_at) }}</td>
					<td>{{ truncate($deposit->tenancy->present()->name) }}</td>
					<td>{{ truncate($deposit->tenancy->property->present()->shortAddress) }}</td>
					<td>{{ currency($deposit->amount) }}</td>
					<td>
						<span class="@if ($deposit->balance < $deposit->amount) text-danger @endif">
							{{ currency($deposit->balance) }}
						</span>
					</td>
					<td>{{ $deposit->unique_id }}</td>
					<td class="text-right">
						<a href="{{ route('deposit.show', $deposit->id) }}" class="btn btn-primary btn-sm">
							View
						</a>
						@if ($deposit->certificate)
							<a href="{{ Storage::url($deposit->certificate->path) }}" target="_blank" class="btn btn-secondary btn-sm" >
								<i class="fa fa-download"></i>
							</a>
						@endif
					</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent