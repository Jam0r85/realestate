@extends('tenancies.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Statements
		@endcomponent

		@component('partials.subtitle')
			Statements History
		@endcomponent

		@component('partials.table')
			@slot('head')
				<th>Amount</th>
				<th>Period</th>
				<th></th>
				<th>User(s)</th>
			@endslot
			@foreach ($tenancy->statements as $statement)
				<tr>
					<td>{{ currency($statement->amount) }}</td>
					<td><a href="{{ route('statements.show', $statement->id) }}">{{ date_formatted($statement->period_from) }} - {{ date_formatted($statement->period_to) }}</a></td>
					<td></td>
					<td>
						@foreach ($statement->users as $user)
							<a href="{{ route('users.show', $user->id) }}">
								<span class="tag is-primary">
									{{ $user->name }}
								</span>
							</a>
						@endforeach
					</td>
				</tr>
			@endforeach
		@endcomponent

	@endcomponent

@endsection