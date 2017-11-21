@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				@slot('url')
					{{ route('users.show', $user->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $user->present()->fullName }}
		@endcomponent

		@component('partials.sub-header')
			Edit Personal Details
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Update Details
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('users.update', $user->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}			

							@include('users.partials.form')

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

			</div>
			<div class="col-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Set Home Address
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('users.update', $user->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="property_id">Property</label>
								<select name="property_id" id="property_id" class="form-control select2">
									<option value="">None</option>
									@foreach (properties() as $property)
										<option @if ($user->property_id == $property->id) selected @endif value="{{ $property->id }}">
											{{ $property->present()->selectName }}
										</option>
									@endforeach
								</select>
							</div>

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

			</div>
		</div>

	@endcomponent

@endsection