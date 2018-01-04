@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('reminder-types.show', $type->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $type->name }}
		@endcomponent

		@component('partials.sub-header')
			Edit Reminder Type
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('reminder-types.update', $type->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}	

					<div class="card mb-3">

						@component('partials.card-header')
							Update Details
						@endcomponent

						<div class="card-body">		

							@component('partials.form-group')
								@slot('label')
									Name
								@endslot
								<input type="text" name="name" id="name" class="form-control" value="{{ old('name') ?? $type->name }}">
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Description
								@endslot
								<textarea name="description" id="description" rows="5" class="form-control">{{ old('description') ?? $type->description }}</textarea>
							@endcomponent

						</div>
						<div class="card-footer">
							@component('partials.save-button')
								Save Changes
							@endcomponent
						</div>
					</div>

				</form>

			</div>
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('reminder-types.update', $type->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}	

					@component('partials.card')
						@slot('header')
							Reminders Frequency
						@endslot

						<div class="card-body">

							@component('partials.alerts.info')
								Setup automatic reminders to be created once the previous reminder has been completed.
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Create Automatically
								@endslot
								<select name="automatic_reminders" id="automatic_reminders" class="form-control">
									<option @if (!$type->getData('automatic_reminders')) selected @endif value="">No</option>
									<option @if ($type->getData('automatic_reminders')) selected @endif value="true">Yes</option>
								</select>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Every
								@endslot
								<div class="row">
									<div class="col-12 col-lg-6">
										<input type="number" step="any" name="frequency" id="frequency" class="form-control" value="{{ $type->getData('frequency') ?? old('frequency') }}" />
									</div>
									<div class="col-12 col-lg-6">
										<select name="frequency_type" id="frequency_type" class="form-control">
											<option @if ($type->getData('frequency_type') == 'week') selected @endif value="week">Weeks</option>
											<option @if ($type->getData('frequency_type') == 'month') selected @endif value="month">Months</option>
											<option @if ($type->getData('frequency_type') == 'year') selected @endif value="year">Years</option>
										</select>
									</div>
								</div>
							@endcomponent

						</div>

						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot

					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection