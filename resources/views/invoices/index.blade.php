@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

				<a href="{{ route('invoices.create') }}" class="btn btn-primary float-right">
					<i class="fa fa-plus"></i> New Invoice
				</a>

			@component('partials.header')
				{{ $title }}
			@endcomponent

		</div>

		{{-- Invoices Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('invoices.search') }}
			@endslot
			@if (session('invoices_search_term'))
				@slot('search_term')
					{{ session('invoices_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Invoices Search --}}

	@endcomponent

	@if (isset($unpaid_invoices))
		@if (count($unpaid_invoices) && $invoices->currentPage() == 1)

			@component('partials.bootstrap.section-with-container')

				<div class="page-title">

					@component('partials.sub-header')
						Unpaid Invoices
						<small class="text-muted">{{ currency($unpaid_invoices->sum('total')) }}</small>
					@endcomponent

				</div>
				
				@component('partials.table')
					@slot('header')
						<th>Number</th>
						<th>Date</th>
						<th>Property</th>
						<th>Total</th>
						<th>Balance</th>
						<th>Users</th>
					@endslot
					@slot('body')
						@foreach ($unpaid_invoices as $invoice)
							@if (!$invoice->isPaid())
								<tr>
									<td>
										<a href="{{ route('invoices.show', $invoice->id) }}" title="{{ $invoice->number }}">
											{{ $invoice->name }}
										</a>
									</td>
									<td>{{ date_formatted($invoice->created_at) }}</td>
									<td>{!! $invoice->property ? truncate($invoice->property->short_name) : '-' !!}</td>
									<td>{{ currency($invoice->total) }}</td>
									<td>{{ count($invoice->items) ? currency($invoice->total_balance) : 'n/a' }}</td>
									<td>
										@include('partials.users-inline', ['users' => $invoice->users])
									</td>
								</tr>
							@endif
						@endforeach
					@endslot
				@endcomponent

				@include('partials.pagination', ['collection' => $unpaid_invoices])

			@endcomponent

		@endif
	@endif

	@component('partials.bootstrap.section-with-container')

		@if (!session('invoices_search_term'))

			<div class="page-title">

				@component('partials.sub-header')
					Paid Invoices
				@endcomponent

			</div>

		@endif

		@include('invoices.partials.invoices-table')

		@if (!request()->segment(2))
			@include('partials.pagination', ['collection' => $invoices->appends(request()->input())])
		@endif
	
	@endcomponent

@endsection