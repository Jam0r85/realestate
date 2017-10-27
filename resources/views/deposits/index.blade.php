@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			@component('partials.header')
				{{ $title }}
			@endcomponent

			@if (isset($deposit_balance))

				@component('partials.sub-header')
					Expected <b>{{ currency($deposits->sum('amount')) }}</b> / Held <b>{{ currency($deposit_balance) }}</b>
				@endcomponent

			@endif

		</div>

		{{-- Deposits Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('deposit.search') }}
			@endslot
			@if (session('deposit_search_term'))
				@slot('search_term')
					{{ session('deposit_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Deposits Search --}}

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<table class="table table-striped table-hover table-responsive">
			<thead>
				<th>Date</th>
				<th>Tenancy</th>
				<th>Property</th>
				<th>Amount</th>
				<th>Balance</th>
				<th>Ref</th>
				<th></th>
			</thead>
			<tbody>
				@foreach ($deposits as $deposit)
					<tr>
						<td>{{ date_formatted($deposit->created_at) }}</td>
						<td>
							<a href="{{ route('tenancies.show', $deposit->tenancy->id) }}" title="{{ $deposit->tenancy->name }}">
								{!! truncate($deposit->tenancy->name) !!}
							</a>
						</td>
						<td>{!! truncate($deposit->tenancy->property->short_name) !!}</td>
						<td>{{ currency($deposit->amount) }}</td>
						<td>
							<span class="@if ($deposit->balance < $deposit->amount) text-danger @endif">
								{{ currency($deposit->balance) }}
							</span>
						</td>
						<td>{{ $deposit->unique_id }}</td>
						<td class="text-right">
							@if ($deposit->certificate)
								<a href="{{ Storage::url($deposit->certificate->path) }}" target="_blank" title="Download">
									<i class="fa fa-download"></i>
								</a>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		@include('partials.pagination', ['collection' => $deposits])

	@endcomponent

@endsection