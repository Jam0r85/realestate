@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
					Return
				</a>

				<h1>{{ $user->name }}</h1>
				<h3>Update user's home address</h3>
			</div>

			<form role="form" method="POST" action="{{ route('users.update-home-address', $user->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<div class="form-group">
					<label for="property_id">Search and choose the property to set as the home for this user.</label>
					<select name="property_id" class="form-control select2">
						<option value="">None</option>
						@foreach (properties() as $property)
							<option @if ($user->property_id == $property->id) selected @endif value="{{ $property->id }}">{{ $property->name }}</option>
						@endforeach
					</select>
				</div>

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Save Changes
				</button>

			</form>

		</div>
	</section>

@endsection