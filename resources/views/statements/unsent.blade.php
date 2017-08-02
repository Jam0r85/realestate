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
				Listed below are all the rental statements which are yet to be sent to their owners.
			</p>
			<p>
				A statement can be sent once it has been updated as having being paid.
			</p>
		</div>

		<form role="form" method="POST" action="{{ route('statements.send') }}">
			{{ csrf_field() }}

			@component('partials.table')
				@slot('head')
					<th></th>
					<th>Period</th>
					<th>Tenancy &amp; Property</th>
					<th>Amount</th>
					<th>Date</th>
					<th>Paid</th>
				@endslot
				@foreach ($statements as $statement)
					<tr>
						<td>
							@if (!$statement->paid_at)
								<input type="checkbox" name="statement_id[]" value="{{ $statement->id }}" />
							@endif
						</td>
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
						<td>{!! $statement->is_paid ? '<span class="tag is-success">Paid</span>' : '<span class="tag is-danger">Not Paid</span>' !!}</td>
					</tr>
				@endforeach
			@endcomponent

			@include('partials.pagination', ['collection' => $statements])

			<hr />

			<button type="submit" class="button is-primary is-outlined" name="action" value="send">
				Send Statements
			</button>

		</form>
	@endcomponent

@endsection