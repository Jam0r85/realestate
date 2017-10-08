@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')
		<div class="page-title">
			<h1>Edit Service - {{ $service->name }}</h1>
		</div>
	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<form role="form" method="POST" action="{{ route('services.update', $service->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" class="form-control" value="{{ $service->name }}" required />
			</div>

			<div class="form-group">
				<label for="description">Description</label>
				<textarea name="description" class="form-control">{{ $service->description }}</textarea>
			</div>

			<div class="form-group">
				<label for="letting_fee">Letting Fee</label>
				<input type="number" step="any" name="letting_fee" class="form-control" value="{{ $service->letting_fee }}" />
			</div>

			<div class="form-group">
				<label for="re_letting_fee">Re-Letting Fee</label>
				<input type="number" step="any" name="re_letting_fee" class="form-control" value="{{ $service->re_letting_fee }}" />
			</div>

			<div class="form-group">
				<label for="charge">Management Charge</label>
				<input type="number" step="any" name="charge" class="form-control" value="{{ $service->charge < 1 ? $service->charge * 100 : $service->charge }}" />
			</div>

			<div class="form-group">
				<label for="charge_type">Management Charge Type</label>
				<select name="charge_type" class="form-control">
					<option @if ($service->charge < 1) selected @endif value="percent">Percent</option>
					<option @if ($service->charge >= 1) selected @endif value="fixed">Fixed Price</option>
				</select>
			</div>

			<div class="form-group">
				<label for="tax_rate_id">Tax Rate</label>
				<select name="tax_rate_id" class="form-control">
					<option value="0">None</option>
					@foreach (tax_rates() as $rate)
						<option @if ($service->tax_rate_id == $rate->id) selected @endif value="{{ $rate->id }}">{{ $rate->name }}</option>
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