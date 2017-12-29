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

							@component('partials.form-group')
								@slot('label')
									Date Vacated
								@endslot
								@component('partials.input-group')
									@slot('icon')
										@lang('icons.calendar')
									@endslot
									<input type="date" name="vacated_on" id="vacated_on" class="form-control" value="{{ $tenancy->vacated_on ? $tenancy->vacated_on->format('Y-m-d') : old('vacated_on') }}" />
								@endcomponent
							@endcomponent

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