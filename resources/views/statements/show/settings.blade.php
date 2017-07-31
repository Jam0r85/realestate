@extends('statements.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Settings
		@endcomponent

		@include('partials.errors-block')

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

			<div class="field">
				<label class="label" for="sending_method">Sending Method</label>
				<div class="control">
					<span class="select is-fullwidth">
						<select name="sending_method">
							<option @if ($statement->property->hasSetting('post_rental_statement')) selected @endif value="post">By Post</option>
							<option @if (!$statement->property->hasSetting('post_rental_statement')) selected @endif value="email">By E-Mail</option>
						</select>
					</span>
				</div>
				<p class="help">
					Changing this will also update the default property setting.
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

			<button type="submit" class="button is-outlined {{ isset($statement->paid_at) ? 'is-danger' : 'is-success' }}">
				Mark {{ isset($statement->paid_at) ? 'Unpaid' : 'Paid' }}
			</button>

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

			<button type="submit" class="button is-outlined {{ isset($statement->sent_at) ? 'is-danger' : 'is-success' }}">
				Mark {{ isset($statement->sent_at) ? 'Unsent' : 'Sent' }}
			</button>

		</form>

	@endcomponent

@endsection