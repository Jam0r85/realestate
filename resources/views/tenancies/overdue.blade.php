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

		<div class="content">

			<form role="form" method="POST" action="{{ route('tenancies.search') }}">
				{{ csrf_field() }}

				<div class="field is-grouped">
					<p class="control is-expanded">
						<input type="text" name="search_term" class="input" value="{{ session('search_term') }}" />
					</p>
					<p class="control">
						@component('partials.forms.buttons.primary')
							Search
						@endcomponent
					</p>
				</div>
			</form>

		</div>

		@component('partials.table')
			@slot('head')
				<th>Name</th>
				<th>Property</th>
				<th>Rent</th>
				<th>Balance</th>
				<th>Due</th>
			@endslot
			@foreach ($tenancies as $tenancy)
				<tr>
					<td><a href="{{ route('tenancies.show', $tenancy->id) }}">{{ $tenancy->name }}</a></td>
					<td>{{ $tenancy->property->short_name }}</td>
					<td>{{ currency($tenancy->rent_amount) }}</td>
					<td>{{ currency($tenancy->rent_balance) }}</td>
					<td>{{ date_formatted($tenancy->next_statement_start_date) }}</td>
				</tr>
			@endforeach
		@endcomponent

		@include('partials.pagination', ['collection' => $tenancies])
	@endcomponent

@endsection