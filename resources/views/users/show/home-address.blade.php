@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('users.show', $user->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $user->name }}</h1>
			<h2 class="subtitle">Edit Details</h2>

			<hr />

			<form role="form" method="POST" action="{{ route('users.update-home-address', $user->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}

				<div class="field">
					<label class="label" for="property_id">Properties Search</label>
					<p class="control">
						<select name="property_id" class="select2">
							<option value="">None</option>
							@foreach (properties() as $property)
								<option @if ($user->property_id == $property->id) selected @endif value="{{ $property->id }}">{{ $property->name }}</option>
							@endforeach
						</select>
					</p>
				</div>

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Save Changes
					</span>
				</button>

			</form>

		</div>
	</section>

@endsection