@extends('properties.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Default Bank Account
		@endcomponent

		<form role="form" method="POST" action="{{ route('properties.update-bank-account', $property->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="field">
				<label class="label" for="bank_account_id">Bank Accounts</label>
				<p class="control">
					<select name="bank_account_id" class="select2">
						<option value="">None</option>
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

	@endcomponent

@endsection