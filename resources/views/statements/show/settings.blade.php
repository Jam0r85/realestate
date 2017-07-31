@extends('statements.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Settings
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
	@endcomponent

	@component('partials.sections.section-no-container')

		@component('partials.subtitle')
			Mark {{ isset($statement->paid_at) ? 'Unpaid' : 'Paid' }}
		@endcomponent

		<div class="content">

			<p>
				You can mark this statement as being paid or unpaid.
			</p>

			@if ($statement->paid_at)
				<p>
					<b>The statement was paid on {{ date_formatted($statement->paid_at) }}</b>
				</p>
			@endif

		</div>

		<hr />

		<form role="form" method="POST" action="{{ route('statements.toggle-paid', $statement->id) }}">
			{{ csrf_field() }}

			@component('partials.forms.buttons.secondary')
				Mark {{ isset($statement->paid_at) ? 'Unpaid' : 'Paid' }}
			@endcomponent

		</form>

	@endcomponent

	@component('partials.sections.section-no-container')

		@component('partials.subtitle')
			Mark {{ isset($statement->sent_at) ? 'Unsent' : 'Sent' }}
		@endcomponent

		<div class="content">
			<p>
				You can mark this statement as being sent or unsent without informing the landlords.
			</p>

			@if ($statement->sent_at)
				<p>
					<b>The statement was sent to the owners on {{ date_formatted($statement->sent_at) }}</b>
				</p>
			@endif

		</div>

		<hr />

		<form role="form" method="POST" action="{{ route('statements.toggle-sent', $statement->id) }}">
			{{ csrf_field() }}

			@component('partials.forms.buttons.secondary')
				Mark {{ isset($statement->sent_at) ? 'Unsent' : 'Sent' }}
			@endcomponent

		</form>

	@endcomponent

@endsection