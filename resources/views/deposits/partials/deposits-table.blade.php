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
					<td>{{ money_formatted($deposit->amount) }}</td>
					<td>{{ money_formatted($deposit->balance) }}</td>
					<td>{{ $deposit->unique_id }}</td>
					<td class="text-right">
						<a href="{{ route('deposits.show', $deposit->id) }}" class="btn btn-primary btn-sm">
							@icon('view')
						</a>
						@if ($deposit->certificate)
							<a href="{{ Storage::url($deposit->certificate->path) }}" target="_blank" class="btn btn-secondary btn-sm" >
								@icon('download')
							</a>
						@endif
					</td>
				</tr>
			@endforeach
		@endslot
	@endcomponent