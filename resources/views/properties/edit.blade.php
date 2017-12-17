@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				@slot('url')
					{{ route('properties.show', $property->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $property->present()->shortAddress }}
		@endcomponent

		@component('partials.sub-header')
			Edit Property Details
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Property Details
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('properties.update', $property->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}				

							@include('properties.partials.form')

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
						Building Information
					@endcomponent
					<div class="card-body">

						<form method="POST" action="{{ route('properties.update', $property->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}	

							<div class="form-group">
								<label for="bedrooms">
									Bedrooms
								</label>
								<select name="bedrooms" id="bedrooms" class="form-control">
									@for($i = 0; $i <= 10; $i++)
										<option @if ($property->getData('bedrooms') == $i) selected @endif value="{{ $i }}">
											@if ($i == 0)
												Studio / None
											@else
												{{ $i }}
											@endif
										</option>
									@endfor
								</select>
							</div>

							<div class="form-group">
								<label for="bathrooms">
									Bathrooms
								</label>
								<select name="bathrooms" id="bathrooms" class="form-control">
									@for($i = 0; $i <= 10; $i++)
										<option @if ($property->getData('bathrooms') == $i) selected @endif value="{{ $i }}">
											@if ($i == 0)
												None
											@else
												{{ $i }}
											@endif
										</option>
									@endfor
								</select>
							</div>

							<div class="form-group">
								<label for="reception_rooms">
									Reception Rooms
								</label>
								<select name="reception_rooms" id="reception_rooms" class="form-control">
									@for($i = 0; $i <= 10; $i++)
										<option @if ($property->getData('reception_rooms') == $i) selected @endif value="{{ $i }}">
											@if ($i == 0)
												None
											@else
												{{ $i }}
											@endif
										</option>
									@endfor
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