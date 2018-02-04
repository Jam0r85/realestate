@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Appearance
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<form method="POST" action="{{ route('appearances.store') }}">
			{{ csrf_field() }}

			<div class="row">
				<div class="col-12 col-lg-6">

					@component('partials.card')
						@slot('header')
							Details
						@endslot
						@slot('body')

							@component('partials.form-group')
								@slot('label')
									Live Date
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" name="live_at" id="live_at" class="form-control" value="{{ old('live_at') ?: date('Y-m-d') }}" />
								@endcomponent
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Visibility
								@endslot
								<select name="hidden" id="hidden" class="form-control">
									<option value="true">Hidden</option>
									<option selected value="false">Visible</option>
								</select>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Section
								@endslot
								<select name="section_id" id="section_id" class="form-control">
									@foreach (common('sections') as $section)
										<option @if (old('section_id') == $section->id) selected @endif value="{{ $section->id }}">
											{{ $section->name }}
										</option>
									@endforeach
								</select>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Property
								@endslot<select name="property_id" id="property_id" class="form-control select2">
									<option value="">Please select..</option>
									@foreach (common('properties') as $property)
										<option @if (old('property_id') == $property->id) selected @endif value="{{ $property->id }}">
											{{ $property->present()->selectName }}
										</option>
									@endforeach
								</select>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Status
								@endslot
								<select name="status_id" id="status_id" class="form-control">
									@foreach (appearance_statuses() as $status)
										<option @if (old('status_id') == $status->id) selected @endif value="{{ $status->id }}">
											{{ $status->name }}
										</option>
									@endforeach
								</select>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Avaliable From
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" name="avaliable_from" id="avaliable_from" class="form-control" value="{{ old('avaliable_from') ?? date('Y-m-d') }}" />
								@endcomponent
							@endcomponent

						@endslot
					@endcomponent

					<div class="card mb-3">
						@component('partials.card-header')
							Features
						@endcomponent
						<div class="card-body">

						</div>
					</div>

				</div>
				<div class="col-12 col-lg-6">

					@component('partials.card')
						@slot('header')
							Price
						@endslot
						@slot('body')

							@component('partials.form-group')
								@slot('label')
									Price
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('money')
									@endslot
									<input type="number" step="any" class="form-control" name="price" id="price" value="{{ old('price') }}" />
								@endcomponent
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Price Qualifier
								@endslot
								<select name="qualifier_id" id="qualifier_id" class="form-control">
									<option value="">None</option>
									@foreach (price_qualifiers() as $qualifier)
										<option @if (old('qualifier_id') == $qualifier->id) selected @endif value="{{ $qualifier->id }}">
											{{ $qualifier->name }}
										</option>
									@endforeach
								</select>
							@endcomponent

						@endslot
					@endcomponent

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

@push('style')
	<link href="{{ asset('css/trumbowyg.css') }}" rel="stylesheet">
@endpush

@push('footer_scripts')
	<script src="{{ asset('js/trumbowyg.js') }}"></script>
	<script>
		$('#description').trumbowyg({
			svgPath: '{{ asset('css/trumbowyg/icons.svg') }}'
		});
	</script>
@endpush