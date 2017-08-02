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
			<p>
				Listed below are all rental statements which are yet to be marked as having being paid.
			</p>
			<p>
				This is done automatically once all the payments for a statement have been marked as having been sent.
			</p>
		</div>

		@component('partials.table')
			@slot('head')
				<th>Period</th>
				<th>Tenancy &amp; Property</th>
				<th>Amount</th>
				<th>Date</th>
				<th>Payments</th>
			@endslot
			@foreach ($statements as $statement)
				<tr>
					<td><a href="{{ route('statements.show', $statement->id) }}">{{ date_formatted($statement->period_start) }} - {{ date_formatted($statement->period_end) }}</a></td>
					<td>
						{{ $statement->tenancy->name }}
						<br />
						<a href="{{ route('properties.show', $statement->property->id) }}">
							<span class="tag is-light">
								{{ $statement->property->short_name }}
							</span>
						</a>
					</td>
					<td>{{ currency($statement->amount) }}</td>
					<td>{{ date_formatted($statement->created_at) }}</td>
					<td>{!! count($statement->payments) ? '<span class="tag is-success">Generated</span>' : '<span class="tag is-danger">Not Generated</span>' !!}</td>
				</tr>
			@endforeach
		@endcomponent

		@include('partials.pagination', ['collection' => $statements])

	@endcomponent

@endsection