@extends('layouts.app')

@section('breadcrumbs')
	<li class="is-active"><a>{{ $title }}</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $title }}
		@endslot
	@endcomponent

	@component('partials.sections.section')

		@component('partials.table')
			@slot('head')
				<th>Name</th>
				<th>Property</th>
				<th>Rent</th>
				<th>Balance</th>
				<th>Due</th>
				<th>Diff</th>
			@endslot
			@foreach ($tenancies as $tenancy)
				<tr>
					<td><a href="{{ route('tenancies.show', $tenancy->id) }}">{{ $tenancy->name }}</a></td>
					<td>{{ $tenancy->property->short_name }}</td>
					<td>{{ currency($tenancy->rent_amount) }}</td>
					<td>{{ currency($tenancy->rent_balance) }}</td>
					<td>{{ date_formatted($tenancy->next_statement_start_date) }}</td>
					<td>{{ $tenancy->days_overdue }}</td>
				</tr>
			@endforeach
		@endcomponent

		@include('partials.pagination', ['collection' => $tenancies])
	@endcomponent

@endsection