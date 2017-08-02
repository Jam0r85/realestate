@extends('tenancies.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Agreements
		@endcomponent

		@component('partials.table')
			@slot('head')
				<th>Start Date</th>
				<th>Length</th>
				<th>End Date</th>
				<th>Status</th>
			@endslot
			@foreach ($tenancy->agreements as $agreement)
				<tr>
					<td>{{ date_formatted($agreement->starts_at) }}</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			@endforeach
		@endcomponent

	@endcomponent

@endsection