@extends('invoices.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Settings
		@endcomponent

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
				<label class="label" for="number">Number</label>
				<p class="control">
					<input type="number" class="input" name="number" value="{{ $invoice->number }}" />
				</p>
			</div>

			<div class="field">
				<label class="label" for="user_id">Users</label>
				<p class="control ix-expanded">
					<select name="user_id[]" class="select2" multiple>
						@foreach (users() as $user)
							<option @if ($invoice->users->contains($user->id)) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
						@endforeach
					</select>
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

	@endcomponent

@endsection