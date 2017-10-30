@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				{{ $expense->name }}
			@endcomponent

			@component('partials.sub-header')
				Edit expense details
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('expenses.update', $expense->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="form-group">
				<label for="property_id">Property</label>
				<select name="property_id" id="property_id" class="form-control select2">
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

			@component('partials.save-button')
				Save Changes
			@endcomponent

		</form>

	@endcomponent

@endsection