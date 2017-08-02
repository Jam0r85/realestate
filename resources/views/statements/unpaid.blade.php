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
				Listed below are all rental statements which are yet to be marked as having being paid. You can mark a statement as being paid by selecting the box clicking the 'Mark as Paid' button at the bottom.
			</p>
			<div class="notification is-primary">
				<b>Important!</b> This will mark every single statement payment as having been sent (and will auto generate the statement payments if none exist)
			</div>
			<p>
				Alternatively when processing a bulk payment to the owners, once all of a statements payments have been marked as having been sent, the statement will automatically be updated to sent status.
			</p>
		</div>

		<form role="form" method="POST" action="{{ route('statements.toggle-paid') }}">
			{{ csrf_field() }}

			@component('partials.table')
				@slot('head')
					<th></th>
					<th>Period</th>
					<th>Tenancy &amp; Property</th>
					<th>Amount</th>
					<th>Date</th>
					<th>Payments</th>
				@endslot
				@foreach ($statements as $statement)
					<tr>
						<td>
							<input type="checkbox" name="statement_id[]" value="{{ $statement->id }}" />
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
						<td>{{ count($statement->payments) ? 'Generated' : 'None' }}</td>
					</tr>
				@endforeach
			@endcomponent

			@include('partials.pagination', ['collection' => $statements])

			<hr />

			<button type="submit" class="button is-success is-outlined" name="action" value="send">
				Mark as Paid
			</button>

		</form>
	@endcomponent

@endsection