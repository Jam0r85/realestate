@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $expense->name }}</h1>
				<h3>Edit expense details</h3>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('expenses.update', $expense->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<div class="form-group">
					<label for="property_id">Property</label>
					<select name="property_id" class="form-control select2">
						<option value="">Please select..</option>
						@foreach(properties() as $property)
							<option 
								@if ($expense->property_id == $property->id) selected @endif
								value="{{ $property->id }}">
									{{ $property->name }} ({{ implode(', ', $property->owners->pluck('name')->toArray()) }})
							</option>
						@endforeach
					</select>
				</div>	

				@include('expenses.partials.form')

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Save Changes
				</button>

			</form>

		</div>
	</section>

@endsection