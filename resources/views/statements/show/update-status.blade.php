@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('statements.show', $statement->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				Statement #{{ $statement->id }}
			@endcomponent

			@component('partials.sub-header')
				Update statement status
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="card mb-3">

			@component('partials.bootstrap.card-header')
				Statement Paid
			@endcomponent

			<form method="POST" action="{{ route('statements.update-paid', $statement->id) }}">
				{{ csrf_field() }}

				<div class="from-control">
					<label for="paid_at">Date Paid</label>
					<input type="date" name="paid_at" id="paid_at" class="form-control" value="{{ $statement->paid_at ? $statement->paid_at->format('Y-m-d') : '' }}" />
				</div>

				@component('partials.save-button')
					Save Changes
				@endcomponent

			</form>

		</div>

	@endcomponent

@endsection