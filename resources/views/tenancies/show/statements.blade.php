@extends('tenancies.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Statements
		@endcomponent

		@component('partials.table')
			@slot('head')
				<th>Period</th>
				<th>Amount</th>
				<th>Date</th>
				<th>Status</th>
			@endslot
			@foreach ($tenancy->statements()->paginate() as $statement)
				<tr>
					<td><a href="{{ route('statements.show', $statement->id) }}">{{ date_formatted($statement->period_start) }} - {{ date_formatted($statement->period_end) }}</a></td>
					<td>{{ currency($statement->amount) }}</td>
					<td>{{ date_formatted($statement->created_at) }}</td>
					<td>
						@if ($statement->sent_at)
							Sent
						@else
							@if ($statement->paid_at)
								Paid
							@else
								Unpaid
							@endif
						@endif
					</td>
				</tr>
			@endforeach
		@endcomponent

		@include('partials.pagination', ['collection' => $tenancy->statements()->paginate()])

	@endcomponent

@endsection