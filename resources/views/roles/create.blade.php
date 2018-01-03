@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Role
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<form action="{{ route('roles.store') }}" method="POST">
			{{ csrf_field() }}

			<div class="row">
				<div class="col-12 col-lg-6">

					@component('partials.card')
						@slot('header')
							Branch
						@endslot

						<div class="card-body">

							@component('partials.alerts.info')
								Please select the branch(s) that this role should be added to.
							@endcomponent

							@component('partials.form-group')
								@foreach (branches() as $branch)
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="{{ $branch->id }}" name="branch_id[]" id="branch_id_{{ $branch->id }}">
										<label class="form-check-label" for="branch_id_{{ $branch->id }}">
											{{ $branch->name }}
										</label>
									</div>
								@endforeach
							@endcomponent

						</div>
					@endcomponent

					@component('partials.card')
						@slot('header')
							Role Details
						@endslot

						<div class="card-body">

							@include('roles.partials.form')

						</div>

						@slot('footer')
							@component('partials.save-button')
								Save Role
							@endcomponent
						@endslot
					@endcomponent

				</div>
				<div class="col-12 col-lg-6">



				</div>
			</div>

		</form>

	@endcomponent

@endsection