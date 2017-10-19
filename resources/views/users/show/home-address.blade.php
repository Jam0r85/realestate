@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
				Return
			</a>
			<h1>{{ $user->name }}</h1>
			<h3 class="text-muted">Set Home Address</h3>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<form method="POST" action="{{ route('users.update-home-address', $user->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="form-group">
				<label for="property_id">Search and choose the property to set as the home for this user.</label>
				<select name="property_id" id="property_id" class="form-control select2">
					<option value="">None</option>
					@foreach (properties() as $property)
						<option @if ($user->property_id == $property->id) selected @endif value="{{ $property->id }}">{{ $property->name }}</option>
					@endforeach
				</select>
			</div>

			@component('partials.bootstrap.save-submit-button')
				Update Home
			@endcomponent

		</form>

	@endcomponent

@endsection