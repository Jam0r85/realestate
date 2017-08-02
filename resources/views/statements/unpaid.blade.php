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

			<form role="form" method="POST" action="{{ route('statements.search') }}">
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

		<form role="form" method="POST" action="{{ route('statements.send') }}">
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
							<label class="checkbox">
								<input type="checkbox" name="statement_id[]" value="{{ $statement->id }}" />
							</label>
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