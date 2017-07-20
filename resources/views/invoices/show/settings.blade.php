@extends('invoices.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Settings
		@endcomponent

		@if ($invoice->paid_at || $invoice->total_balance <= 0 || $invoice->trashed())

			@component('partials.notifications.primary')
				You cannot update the settings for this invoice as it's been paid or archived.
			@endcomponent
		
		@else

			<form role="form" method="POST" action="{{ route('invoices.update', $invoice->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<div class="field">
					<label class="label" for="created_at">Date Created</label>
					<p class="control">
						<input type="date" class="input" name="created_at" value="{{ $invoice->created_at->format('Y-m-d') }}" />
					</p>
				</div>

				<div class="field">
					<label class="label" for="due_at">Date Due</label>
					<p class="control">
						<input type="date" class="input" name="due_at" value="{{ $invoice->due_at ? $invoice->due_at->format('Y-m-d') : null }}" />
					</p>
				</div>

				<div class="field">
					<label class="label" for="recipient">Recipient</label>
					<p class="control">
						<textarea name="recipient" class="textarea">{{ $invoice->recipient }}</textarea>
					</p>
				</div>

				<div class="field">
					<label class="label" for="terms">Terms</label>
					<p class="control">
						<textarea name="terms" class="textarea">{{ $invoice->terms }}</textarea>
					</p>
				</div>

				@component('partials.forms.buttons.primary')
					Update
				@endcomponent

			</form>

		@endif

	@endcomponent

@endsection