@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<h1>
				{{ $title }}
				<a href="{{ route('tenancies.create') }}" class="btn btn-primary">
					<i class="fa fa-plus"></i> New Tenancy
				</a>
			</h1>
		</div>

		{{-- Tenancies Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('tenancies.search') }}
			@endslot
			@if (session('tenancies_search_term'))
				@slot('search_term')
					{{ session('tenancies_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Tenancies Search --}}

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<table class="table table-striped table-hover table-responsive">
			<thead>
				<th>Name</th>
				<th>Property</th>
				<th>Rent</th>
				<th>Balance</th>
				<th>Service</th>
				<th>Status</th>
			</thead>
			<tbody>
				@foreach ($tenancies as $tenancy)
					<tr>
						<td>
							<a href="{{ route('tenancies.show', $tenancy->id) }}" title="{{ $tenancy->name }}">
								{!! truncate($tenancy->name) !!}
							</a>
						</td>
						<td>{!! truncate($tenancy->property->short_name) !!}</td>
						<td>{{ currency($tenancy->rent_amount) }}</td>
						<td>
							@include('tenancies.format.rent-balance')
						</td>
						<td>{{ $tenancy->service->name }}</td>
						<td>@include('tenancies.partials.table-status-label')</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		@include('partials.pagination', ['collection' => $tenancies])

	@endcomponent

@endsection