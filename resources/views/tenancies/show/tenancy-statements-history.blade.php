@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('tenancies.show', $tenancy->id) }}" class="btn btn-secondary float-right">
			Return
		</a>

		@component('partials.header')
			{{ $tenancy->name }}
		@endcomponent

		@component('partials.sub-header')
			Statements list
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@component('partials.table')
			@slot('header')
				<th>Date</th>
				<th>Start</th>
				<th>End</th>
				<th>Amount</th>
				<th>Landlord</th>
				<th>Invoice</th>
				<th>Status</th>
				<th>PDF</th>
			@endslot
			@slot('body')
				@foreach ($tenancy->statements()->paginate() as $statement)
					<tr>
						<td>
							<a href="{{ route('statements.show', $statement->id) }}">
								 {{ date_formatted($statement->created_at) }}
							</a>
						</td>
						<td>{{ date_formatted($statement->period_start) }}</td>
						<td>{{ date_formatted($statement->period_end) }}</td>
						<td>{{ currency($statement->amount) }}</td>
						<td>{{ currency($statement->landlord_balance_amount) }}</td>
						<td>
							@if ($statement->invoice)
								<a href="{{ route('invoices.show', $statement->invoice->id) }}">
									{{ $statement->invoice->number }}
								</a>
							@endif
						</td>
						<td>
							@if ($statement->sent_at)
								Sent {{ date_formatted($statement->sent_at) }}
							@else
								@if ($statement->paid_at)
									Paid
								@else
									Unpaid
								@endif
							@endif
						</td>
						<td>
							<a href="{{ route('downloads.statement', $statement->id) }}" target="_blank">
								Download
							</a>
						</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

		@include('partials.pagination', ['collection' => $tenancy->statements()->paginate()])

	@endcomponent

@endsection