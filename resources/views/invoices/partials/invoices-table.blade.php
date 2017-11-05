@component('partials.table')
	@slot('header')
		<th>Number</th>
		<th>Date</th>
		<th>Property</th>
		<th>Total</th>
		<th>Users</th>
		<th class="text-right">Paid</th>
	@endslot
	@slot('body')
		@foreach ($invoices as $invoice)
			<tr>
				<td>
					<a href="{{ route('invoices.show', $invoice->id) }}" title="{{ $invoice->number }}">
						{{ $invoice->name }}
					</a>
				</td>
				<td>{{ date_formatted($invoice->created_at) }}</td>
				<td>{!! $invoice->property ? truncate($invoice->property->short_name) : '-' !!}</td>
				<td>{!! $invoice->trashed() ? '<span class="text-muted"><i class="fa fa-archive"></i> Archived</span>' : currency($invoice->total) !!}</td>
				<td>
					@include('partials.users-inline', ['users' => $invoice->users])
				</td>
				<td class="text-right">
					@if ($invoice->paid_at)
						{{ date_formatted($invoice->paid_at) }}
					@else
						<span class="text-danger">
							Unpaid
						</span>
					@endif
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent