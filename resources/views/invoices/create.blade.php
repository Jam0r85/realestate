@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Invoice
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="card mb-3">
			@component('partials.card-header')
				Invoice Details
			@endcomponent

			<div class="card-body">

				<form method="POST" action="{{ route('invoices.store') }}">
					{{ csrf_field() }}					

					<div class="form-group">
						<label for="invoice_group_id">Invoice Group</label>
						<select name="invoice_group_id" class="form-control">
							@foreach (invoiceGroups() as $invoice_group)
								<option @if (old('invoice_group_id') == $invoice_group->id) selected @endif value="{{ $invoice_group->id }}">{{ $invoice_group->name }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="property_id">Property</label>
						<select name="property_id" class="form-control select2">
							<option value="" disabled selected></option>
							@foreach (properties() as $property)
								<option @if (old('property_id') == $property->id) selected @endif value="{{ $property->id }}">
									{{ $property->present()->selectName }}
								</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="users">Users</label>
						<select name="users[]" class="form-control select2" multiple>
							@foreach (users() as $user)
								<option @if (old('users') && in_array($user->id, old('users'))) selected @endif value="{{ $user->id }}">
									{{ $user->present()->selectName }}
								</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="number">Invoice Number (optional)</label>
						<input type="text" name="number" class="form-control" value="{{ old('number') }}" />
						<small class="form-text text-muted">
							Enter a number to use for this invoice instead of using the next avaliable number.
						</small>
					</div>

					<div class="form-group">
						<label for="terms">Terms</label>
						<textarea name="terms" id="terms" class="form-control" rows="7">{{ old('terms') ?? get_setting('invoice_default_terms') }}</textarea>
					</div>

					@component('partials.save-button')
						Create Invoice
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection