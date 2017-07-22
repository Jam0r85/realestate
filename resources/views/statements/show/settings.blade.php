@extends('statements.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Settings
		@endcomponent

		@component('partials.subtitle')
			Update Statement Details
		@endcomponent

		<form role="form" method="POST" action="{{ route('statements.update', $statement->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="field">
				<label class="label" for="period_start">Date From</label>
				<p class="control">
					<input type="date" name="period_start" class="input" value="{{ $statement->period_start->format('Y-m-d') }}" />
				</p>
			</div>

			<div class="field">
				<label class="label" for="period_end">Date End</label>
				<p class="control">
					<input type="date" name="period_end" class="input" value="{{ $statement->period_end->format('Y-m-d') }}" />
				</p>
			</div>

			@component('partials.forms.buttons.primary')
				Update
			@endcomponent

		</form>

		<hr />

		@component('partials.subtitle')
			Mark as {{ isset($statement->paid_at) ? 'Unpaid' : 'Paid' }}
		@endcomponent

		<form role="form" method="POST" action="{{ route('statements.toggle-paid', $statement->id) }}">
			{{ csrf_field() }}

			@component('partials.forms.buttons.primary')
				Mark {{ isset($statement->paid_at) ? 'Unpaid' : 'Paid' }}
			@endcomponent

		</form>

		<hr />

		@component('partials.subtitle')
			Mark as {{ isset($statement->sent_at) ? 'Unsent' : 'Sent' }}
		@endcomponent

		@if ($statement->sent_at)
			@component('partials.notifications.primary')
				The statement was sent to the owners on {{ date_formatted($statement->sent_at) }}
			@endcomponent
		@endif

		<form role="form" method="POST" action="{{ route('statements.toggle-sent', $statement->id) }}">
			{{ csrf_field() }}

			@component('partials.forms.buttons.primary')
				Mark {{ isset($statement->sent_at) ? 'Unsent' : 'Sent' }}
			@endcomponent

		</form>

	@endcomponent

@endsection