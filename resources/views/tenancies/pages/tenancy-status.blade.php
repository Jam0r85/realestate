@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<a href="{{ route('tenancies.show', $tenancy->id) }}" class="btn btn-secondary float-right">
				Return
			</a>
			<h1>{{ $tenancy->name }}</h1>
			<h3 class="text-muted">Tenancy Status</h3>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="card border-primary mb-3">
			<h5 class="card-header bg-primary text-white">
				Tenants Vacating or Vacated
			</h5>
			<div class="card-body">

				<form method="POST" action="{{ route('tenancies.tenants-vacated', $tenancy->id) }}">
					{{ csrf_field() }}

					<div class="form-group">
						<label for="vacated_on">Date</label>
						<input type="date" name="vacated_on" id="vacated_on" class="form-control" value="{{ $tenancy->vacated_on ? $tenancy->vacated_on->format('Y-m-d') : old('vacated_on') }}" />
						<small class="form-text text-muted">
							Enter the date that the tenants will be vacating or have vacated.
						</small>
					</div>

					@component('partials.bootstrap.save-submit-button')
						Save Changes
					@endcomponent
					
				</form>

			</div>
		</div>

		@if ($tenancy->trashed())

		@else

			<div class="card border-secondary mb-3">
				<h5 class="card-header bg-secondary text-white">
					Archive Tenancy
				</h5>
				<div class="card-body">

					<form method="POST" action="{{ route('tenancies.archive', $tenancy->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						<p class="card-text">
							To confirm that you want to archive this tenancy enter the tenancy ID ({{ $tenancy->id }}) into the field below.
						</p>

						<div class="form-group">
							<input type="text" name="confirmation" id="archiveConfirmation" class="form-control" />
						</div>

						<button type="submit" class="btn btn-secondary">
							<i class="fa fa-archive fa-fw"></i> Archive Tenancy
						</button>
						
					</form>

				</div>
			</div>

		@endif

	@endcomponent

@endsection