@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Appearance
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('appearances.store') }}">
			{{ csrf_field() }}

			<div class="row">
				<div class="col-12 col-lg-6">

					<div class="card mb-3">
						@component('partials.card-header')
							Appearance Details
						@endcomponent
						<div class="card-body">

							<div class="form-group">
								<label for="live_at">
									Live Date
								</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="date" name="live_at" id="live_at" class="form-control" value="{{ old('live_at') ?: date('Y-m-d') }}">
								</div>
							</div>

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
										<option @if (old('section_id') == $section->id) selected @endif value="{{ $section->id }}">
											{{ $section->name }}
										</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label for="property_id">
									Property
								</label>
								<select name="property_id" id="property_id" class="form-control select2">
									@foreach (properties() as $property)
										<option @if (old('property_id') == $property->id) selected @endif value="{{ $property->id }}">
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
										<option @if (old('status_id') == $status->id) selected @endif value="{{ $status->id }}">
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

							<div class="form-group">
								<label for="price">
									Price
								</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-money-bill"></i>
									</span>
									<input type="number" step="any" class="form-control" name="price" id="price" value="{{ old('price') }}">
								</div>
							</div>

							<div class="form-group">
								<label for="qualifier_id">
									Price Qualifier
								</label>
								<select name="qualifier_id" id="qualifier_id" class="form-control">
									@foreach (price_qualifiers() as $qualifier)
										<option @if (old('qualifier_id') == $qualifier->id) selected @endif value="{{ $qualifier->id }}">
											{{ $qualifier->name }}
										</option>
									@endforeach
								</select>
							</div>

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
								<textarea name="summary" id="summary" rows="6" class="form-control">{{ old('summary') }}</textarea>
							</div>

							<div class="form-group">
								<label for="description">
									Description
								</label>
								<textarea name="description" id="description" rows="10" class="form-control">{{ old('description') }}</textarea>
							</div>

						</div>
					</div>

				</div>
			</div>

			@component('partials.save-button')
				Save Appearance
			@endcomponent

		</form>

	@endcomponent

@endsection