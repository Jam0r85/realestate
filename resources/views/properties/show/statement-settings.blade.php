@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')
		<div class="page-title">

			<div class="page-title">
				<a href="{{ route('properties.show', $property->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $property->short_name }}</h1>
				<h3>Update tenancy rental statement settings</h3>
			</div>

		</div>
	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form role="form" method="POST" action="{{ route('properties.update-statement-settings', $property->id) }}">
			{{ csrf_field() }}

			<div class="form-group">
				<label for="bank_account_id">Bank Account</label>
				<select name="bank_account_id" class="form-control select2">
					<option value="0">None</option>
					@foreach (bank_accounts($property->owners->pluck('id')->toArray()) as $account)
						<option @if ($property->bank_account_id == $account->id) selected @endif value="{{ $account->id }}">{{ $account->name }}</option>
					@endforeach
				</select>
				<small class="form-text text-muted">
					Select the bank account to be used by default for rental statements created for tenancies which belong to this property.
				</small>
			</div>

			<div class="form-group">
				<label for="sending_method">Send Statement</label>
				<select name="sending_method" class="form-control">
					<option @if ($property->hasSetting('post_rental_statement')) selected @endif value="post">By Post</option>
					<option @if (!$property->hasSetting('post_rental_statement')) selected @endif value="email">By E-Mail</option>
				</select>
				<small class="form-text text-muted">
					Select how the owners of this property wish to receive their rental statements.
				</small>
			</div>

			@component('partials.bootstrap.save-submit-button')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

@endsection