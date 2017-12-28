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

				<div class="card mb-3">

					@component('partials.card-header')
						Service
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('tenancies.update', $tenancy->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="service_id">Service</label>
								<select name="service_id" id="service_id" class="form-control">
									@foreach (services() as $service)
										<option @if ($tenancy->service->id == $service->id) selected @endif value="{{ $service->id }}">
											{{ $service->present()->selectName }}
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

				<div class="card mb-3">
					@component('partials.card-header')
						Tenancy Dates
					@endcomponent
					<div class="card-body">

						<form method="POST" action="{{ route('tenancies.update', $tenancy->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							<div class="form-group">
								<label for="vacated_on">Tenancy Vacated</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="date" name="vacated_on" id="vacated_on" class="form-control" value="{{ $tenancy->vacated_on ? $tenancy->vacated_on->format('Y-m-d') : old('vacated_on') }}" />
								</div>
							</div>

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

			</div>
			<div class="col-12 col-lg-6">


			</div>
		</div>

	@endcomponent

@endsection