@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Create Property
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="card mb-3">

			@component('partials.card-header')
				Property Details
			@endcomponent

			<div class="card-body">

				<form method="POST" action="{{ route('properties.store') }}">
					{{ csrf_field() }}

					<div class="form-group">
						<label for="branch_id">Branch</label>
						<select name="branch_id" class="form-control">
							@foreach (branches() as $branch)
								<option value="{{ $branch->id }}">{{ $branch->name }}</option>
							@endforeach
						</select>
					</div>

					@include('properties.partials.form')

					@component('partials.save-button')
						Create Property
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection