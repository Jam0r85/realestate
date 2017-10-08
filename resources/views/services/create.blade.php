@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')
		<div class="page-title">
			<h1>Create Service</h1>
		</div>
	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<form role="form" method="POST" action="{{ route('services.store') }}">
			{{ csrf_field() }}

			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" class="form-control" value="{{ old('name') }}" required />
			</div>

			<div class="form-group">
				<label for="description">Description</label>
				<textarea name="description" class="form-control">{{ old('description') }}</textarea>
			</div>

			<div class="form-group">
				<label for="letting_fee">Letting Fee</label>
				<input type="number" step="any" name="letting_fee" class="form-control" value="{{ old('letting_fee') }}" />
			</div>

			<div class="form-group">
				<label for="re_letting_fee">Re-Letting Fee</label>
				<input type="number" step="any" name="re_letting_fee" class="form-control" value="{{ old('re_letting_fee') }}" />
			</div>

			<div class="form-group">
				<label for="charge">Management Charge</label>
				<input type="number" step="any" name="charge" class="form-control" value="{{ old('charge') }}" />
			</div>

			<div class="form-group">
				<label for="charge_type">Management Charge Type</label>
				<select name="charge_type" class="form-control">
					<option value="percent">Percent</option>
					<option value="fixed">Fixed Price</option>
				</select>
			</div>

			<div class="form-group">
				<label for="tax_rate_id">Tax Rate</label>
				<select name="tax_rate_id" class="form-control">
					<option value="0">None</option>
					@foreach (tax_rates() as $rate)
						<option value="{{ $rate->id }}">{{ $rate->name }}</option>
					@endforeach
				</select>
				<small class="form-text text-muted">
					Tax rate is applied to all the above amounts.
				</small>
			</div>

			@component('partials.bootstrap.save-submit-button')
				Create Service
			@endcomponent

		</form>

	@endcomponent

@endsection