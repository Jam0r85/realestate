@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>Create Expense</h1>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="property_id">Property</label>
					<select name="property_id" class="form-control select2">
						<option value="">Please select..</option>
						@foreach(properties() as $property)
							<option 
								@if (old('property_id') == $property->id) selected @endif
								value="{{ $property->id }}">
									{{ $property->name }} ({{ implode(', ', $property->owners->pluck('name')->toArray()) }})
							</option>
						@endforeach
					</select>
				</div>

				@include('expenses.partials.form')

				<div class="form-group">
					<label for="files">Invoice(s)</label>
					<input type="file" class="form-control-file" name="files[]" multiple />
				</div>

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Create Expense
				</button>

			</form>

		</div>
	</section>

@endsection