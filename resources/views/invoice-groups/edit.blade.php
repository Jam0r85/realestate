@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('invoice-groups.show', $group->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $group->name }}
		@endcomponent

		@component('partials.sub-header')
			Edit Invoice Group
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('invoice-groups.update', $group->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}	

					<div class="card mb-3">

						@component('partials.card-header')
							Update Details
						@endcomponent

						<div class="card-body">		

							@include('invoice-groups.partials.form')

						</div>
						<div class="card-footer">
							@component('partials.save-button')
								Save Changes
							@endcomponent
						</div>
					</div>

				</form>

			</div>
			<div class="col-12 col-lg-6">


			</div>
		</div>

	@endcomponent

@endsection