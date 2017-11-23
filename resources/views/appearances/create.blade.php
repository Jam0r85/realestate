@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Appearance
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col-12 col-lg-6">

				<div class="card mb-3">
					@component('partials.card-header')
						Appearance Details
					@endcomponent
					<div class="card-body">

						<div class="form-group">
							<label for="hidden">
								Visibility
							</label>
							<select name="hidden" id="hidden" class="form-control" disabled>
								<option selected value="true">Hidden</option>
								<option value="false">Visible</option>
							</select>
							<small class="form-text text-muted">
								All new appearances are automatically hidden.
							</small>
						</div>

						<div class="form-group">
							<label for="section_id">
								Section
							</label>
							<select name="section_id" id="section_id" class="form-control">
								@foreach (sections() as $section)
									<option value="{{ $section->id }}">
										{{ $section->name }}
									</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="property_id">
								Property
							</label>
							<select name="property_id" id="property_id" class="form-control">
								@foreach (properties() as $property)
									<option value="{{ $property->id }}">
										{{ $property->present()->selectName }}
									</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="status_id">
								Status
							</label>
							<select name="status_id" id="status_id" class="form-control">
								@foreach (appearance_statuses() as $status)
									<option value="{{ $status->id }}">
										{{ $status->name }}
									</option>
								@endforeach
							</select>
						</div>

					</div>
				</div>

				<div class="card mb-3">
					@component('partials.card-header')
						Features
					@endcomponent
					<div class="card-body">

					</div>
				</div>

			</div>
			<div class="col-12 col-lg-6">

				<div class="card mb-3">
					@component('partials.card-header')
						Price
					@endcomponent
					<div class="card-body">

					</div>
				</div>

				<div class="card mb-3">
					@component('partials.card-header')
						Description and Summary
					@endcomponent
					<div class="card-body">

						<div class="form-group">
							<label for="summary">
								Summary
							</label>
							<textarea name="summary" id="summary" rows="6" class="form-control"></textarea>
						</div>

						<div class="form-group">
							<label for="description">
								Description
							</label>
							<textarea name="description" id="description" rows="10" class="form-control"></textarea>
						</div>

					</div>
				</div>

			</div>
		</div>

	@endcomponent

@endsection