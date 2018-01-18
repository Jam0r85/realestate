@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('permissions.index') }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $permission->name }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('permissions.update', $permission->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Update Details
						@endslot

						<div class="card-body">		

							@include('permissions.partials.form')

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


			</div>
		</div>

	@endcomponent

@endsection