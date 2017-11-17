@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('branches.show', $branch->id) }}" class="btn btn-secondary float-right">
			Return
		</a>

		@component('partials.header')
			{{ $branch->name }}
		@endcomponent

		@component('partials.sub-header')
			Edit Branch Details
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Branch Details
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('branches.update', $branch->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}			

							@include('branches.partials.form')

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>

				</div>

			</div>
		</div>

	@endcomponent

@endsection