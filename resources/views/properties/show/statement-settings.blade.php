@extends('properties.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Statement Settings
		@endcomponent

		@component('partials.subtitle')
			Bank account for statements
		@endcomponent

		<form role="form" method="POST" action="{{ route('properties.update-bank-account', $property->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="field">
				<label class="label" for="bank_account_id">Bank Account</label>
				<p class="control">
					<select name="bank_account_id" class="select2">
						<option value="0">None</option>
						@foreach (bank_accounts($property->owners->pluck('id')->toArray()) as $account)
							<option @if ($property->bank_account_id == $account->id) selected @endif value="{{ $account->id }}">{{ $account->name }}</option>
						@endforeach
					</select>
				</p>
			</div>

			@component('partials.forms.buttons.primary')
				Update
			@endcomponent

		</form>

		@component('partials.subtitle')
			How do we send the statement?
		@endcomponent

		<form role="form" method="POST" action="{{ route('properties.update-statement-sending', $property->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="field">
				<label class="label" for="sending_method">Sending Method</label>
				<p class="control is-expanded">
					<span class="select is-fullwidth">
						<select name="sending_method">
							<option @if ($property->hasSetting('post_rental_statement')) selected @endif value="post">By Post</option>
							<option @if (!$property->hasSetting('post_rental_statement')) selected @endif value="email">By E-Mail</option>
						</select>
					</span>
				</p>
			</div>

			@component('partials.forms.buttons.primary')
				Update
			@endcomponent

		</form>

	@endcomponent

@endsection