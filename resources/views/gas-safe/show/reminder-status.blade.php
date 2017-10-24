@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('gas-safe.show', $gas->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				{{ $gas->property->short_name }}
			@endcomponent

			@component('partials.sub-header')
				Gas inspection status
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		@if (!$gas->is_completed)

			<div class="card mb-3 border-success">

				@component('partials.card-header')
					Complete Inspection
					@slot('style')
						bg-success text-white
					@endslot
				@endcomponent

				<div class="card-body">

					<form method="POST" action="{{ route('gas-safe.completed', $gas->id) }}">
						{{ csrf_field() }}

						<div class="form-group">
							<label for="expires_on">Date Completed</label>
							<input type="date" name="expires_on" id="expires_on" class="form-control" />
						</div>

						<button type="submit" class="btn btn-success">
							<i class="fa fa-check fa-fw"></i> Inspection Completed
						</button>

					</form>

				</div>
			</div>

		@endif

		<div class="card mb-3 border-danger">

			@component('partials.card-header')
				Delete Inspection
				@slot('style')
					bg-danger text-white
				@endslot
			@endcomponent

			<div class="card-body">

				@if ($gas->is_completed)

					<div class="alert alert-warning mb-0">
						This gas safe inspection has been marked as complete and cannot be deleted.
					</div>

				@else

					<p class="card-text">
						You can delete this gas safe inspection by entering the ID ({{ $gas->id }}) into the field below.
					</p>

					<p class="card-text">
						This is useful for example if we stop managing a tenancy and don't want any future reminders.
					</p>

					<form method="POST" action="{{ route('gas-safe.destroy', $gas->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						<div class="form-group">
							<input type="text" name="confirmation" id="confirmation" class="form-control" required />
						</div>

						<button type="submit" class="btn btn-danger">
							<i class="fa fa-trash fa-fw"></i> Delete Reminder
						</button>

					</form>

				@endif

			</div>
		</div>

	@endcomponent

@endsection