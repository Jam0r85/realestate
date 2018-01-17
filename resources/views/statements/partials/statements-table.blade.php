@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Starts</th>
		<th>Ends</th>
		@if (!isset($tenancy))
			<th>Tenancy</th>
			<th>Property</th>
		@endif
		<th>Amount</th>
		@if (isset($tenancy))
			<th>Landlord</th>
		@endif
	@endslot
	@slot('body')
		@foreach ($statements as $statement)
			<tr class="clickable-row" data-href="{{ route('statements.show', $statement->id) }}" data-toggle="tooltip" data-placement="left" title="View Statement {{ $statement->id }}">
				<td>{{ $statement->present()->statusLabel }}</td>
				<td>{{ $statement->present()->dateStart }}</td>
				<td>{{ $statement->present()->dateEnd }}</a></td>
				@if (!isset($tenancy))
					<td>{{ truncate($statement->present()->tenancyName) }}</td>
					<td>{{ truncate($statement->present()->propertyAddress) }}</td>
				@endif
				<td>{{ $statement->present()->money('amount') }}</td>
				@if (isset($tenancy))
					<td>{{ $statement->present()->money('landlord_payment') }}</td>
				@endif
				<td class="text-right text-nowrap">
						
					{{-- Send the Statement Form --}}
					@if ($statement->canSend())
						<form method="POST" action="{{ route('statements.send', $statement->id) }}" class="d-inline">
							{{ csrf_field() }}
							<button type="submit" class="btn btn-info btn-sm" title="Send">
								@icon('sent')
							</button>
						</form>
					@endif

				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent