@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('tenancies.show', $tenancy->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $tenancy->present()->name }}
		@endcomponent

		@component('partials.sub-header')
			Edit Tenancy
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('tenancies.update', $tenancy->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Service
						@endslot

						<div class="card-body">

							@component('partials.form-group')
								@slot('label')
									Date Started
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" name="started_on" id="started_on" class="form-control" value="{{ $tenancy->started_on ? $tenancy->started_on->format('Y-m-d') : old('started_on') }}" />
								@endcomponent
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Service
								@endslot
								<select name="service_id" id="service_id" class="form-control">
									@foreach (services() as $service)
										<option @if ($tenancy->service->id == $service->id) selected @endif value="{{ $service->id }}">
											{{ $service->present()->selectName }}
										</option>
									@endforeach
								</select>
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
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('tenancies.update', $tenancy->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Vacating or Vacated
						@endslot

						<div class="card-body">

							@component('partials.form-group')
								@slot('label')
									Date Vacated/Vacating
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@icon('calendar')
									@endslot
									<input type="date" name="vacated_on" id="vacated_on" class="form-control" value="{{ $tenancy->vacated_on ? $tenancy->vacated_on->format('Y-m-d') : old('vacated_on') }}" />
								@endcomponent
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