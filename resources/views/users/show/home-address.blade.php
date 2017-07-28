@extends('users.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')
		
		@component('partials.title')
			User's Home Address
		@endcomponent

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

			@component('partials.forms.buttons.primary')
				Update
			@endcomponent

		</form>

	@endcomponent

@endsection