@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Maintenance Issue
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<form action="{{ route('maintenances.store') }}" method="POST">
			{{ csrf_field() }}

			<div class="row">
				<div class="col-12 col-lg-6">

					@component('partials.card')
						@slot('header')
							Tenancy
						@endslot
						@slot('body')

							@component('partials.alerts.info')
								@icon('info') Has this issue been reported by a tenant or does it relate to a tenancy? Note that selecting a tenancy will link the issue to the property it belongs to.
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Tenancy
								@endslot
								<select name="tenancy_id" id="tenancy_id" class="form-control select2">
									<option value="">Please select..</option>
									@foreach (common('tenancies') as $tenancy)
										<option value="{{ $tenancy->id }}">
											{{ $tenancy->present()->selectName }}
										</option>
									@endforeach
								</select>
							@endcomponent

						@endslot
					@endcomponent

					@component('partials.card')
						@slot('header')
							Property
						@endslot
						@slot('body')

							@component('partials.form-group')
								@slot('label')
									Property
								@endslot
								<select name="property_id" id="property_id" class="form-control select2">
									<option value="">Please select..</option>
									@foreach (common('properties') as $property)
										<option value="{{ $property->id }}">
											{{ $property->present()->selectName }}
										</option>
									@endforeach
								</select>
							@endcomponent

						@endslot
					@endcomponent

					@component('partials.card')
						@slot('header')
							Issue Details
						@endslot
						@slot('body')

							<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />

							@include('maintenances.partials.form')

						@endslot
						@slot('footer')
							@component('partials.save-button')
								Save Issue
							@endcomponent
						@endslot
					@endcomponent

				</div>
				<div class="col-12 col-lg-6">

					@component('partials.card')
						@slot('header')
							Latest Issues
						@endslot

						<div class="list-group list-group-flush">
							@foreach ($latest_issues as $issue)
								<a href="{{ route('maintenances.show', $issue->id) }}" class="list-group-item list-group-item-action">
									{{ $issue->name }}
								</a>
							@endforeach
						</div>

					@endcomponent

				</div>
			</div>

		</form>

	@endcomponent

@endsection

@push('footer_scripts')
<script>
	// Check whether to disable the property dropdown depending on the value of the tenancy dropdown.
	$('#tenancy_id').change(function() {

		var value = $(this).val();

		// Disable property_id if an option is selected from tenancy_id
		if (value > 0) {
			$('#property_id').prop('disabled', true);
		} else {
			$('#property_id').prop('disabled', false);
		}

	});
</script>
@endpush