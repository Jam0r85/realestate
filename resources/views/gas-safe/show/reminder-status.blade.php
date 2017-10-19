@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<a href="{{ route('gas-safe.show', $reminder->id) }}" class="btn btn-secondary float-right">
				Return
			</a>
			<h1>{{ $reminder->property->short_name }}</h1>
			<h3 class="text-muted">
				Gas Safe Reminder Status
			</h3>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="card mb-3 border-danger">
			<h4 class="card-header bg-danger text-white">
				Delete Reminder
			</h4>
			<div class="card-body">

				@if ($reminder->is_completed)

					<div class="alert alert-warning">
						This gas safe reminder has been marked as complete and cannot be deleted.
					</div>

				@else

					<p class="card-text">
						You can delete this gas safe reminder by entering the ID ({{ $reminder->id }}) into the field below.
					</p>

					<p class="card-text">
						This is useful for example if we stop managing a tenancy and don't want any future reminders.
					</p>

					<form method="POST" action="{{ route('gas-safe.destroy', $reminder->id) }}">
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