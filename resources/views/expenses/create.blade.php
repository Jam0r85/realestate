@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<h1>Create Expense</h1>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
			{{ csrf_field() }}

			<div class="form-group">
				<label for="property_id">Property</label>
				<select name="property_id" id="property_id" class="form-control select2">
					<option value="">Please select..</option>
					@foreach(properties() as $property)
						<option @if (old('property_id') == $property->id) selected @endif value="{{ $property->id }}">
							{{ $property->name }} {{ count($property->owners) ? '(' . implode(', ', $property->owners->pluck('name')->toArray()) . ')' : '' }}
						</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="name">Expense Name</label>
				<input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" />
			</div>

			<div class="form-group">
				<label for="cost">Expense Cost</label>
				<input class="form-control" type="number" step="any" name="cost" id="cost" value="{{ old('cost') }}" />
			</div>

			<div class="form-group">
				<label for="contractor_id">Contractor</label>
				<select name="contractor_id" id="contractor_id" class="form-control select2">
					@foreach (users() as $user)
						<option @if (old('contractor_id') && old('contractor_id') == $user->id)) selected @endif value="{{ $user->id }}">
							{{ $user->name }}
						</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="contractor_reference">Contractor Reference (Invoice Number)</label>
				<input class="form-control" type="text" name="contractor_reference" id="contractor_reference" value="{{ old('contractor_reference') }}" />
			</div>

			<div class="form-group">
				<label for="files">Upload Invoice(s)</label>
				<input type="file" id="files" class="form-control-file" name="files[]" multiple />
			</div>

			@component('partials.bootstrap.save-submit-button')
				Create Expense
			@endcomponent

		</form>

	@endcomponent

@endsection