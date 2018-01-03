@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('roles.index') }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $role->name }}
		@endcomponent

		@component('partials.sub-header')
			{{ $role->branch->name }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('roles.update', $role->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							@icon('branch') Branch
						@endslot

						<div class="card-body">

							<p class="card-text">
								You can change the branch which this role is assigned to by selecting a new branch below. Note that this will also transfer all linked staff to the new branch as well.
							</p>

							@component('partials.alerts.info')
								Current branch for this role is <b>{{ $role->branch->name }}</b>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									New Branch
								@endslot
								<select name="branch_id" id="branch_id" class="form-control">
									@foreach (branches() as $branch)
										@if ($role->branch_id != $branch->id)
											<option value="{{ $branch->id }}">
												{{ $branch->name }}
											</option>
										@endif
									@endforeach
								</select>
							@endcomponent

						</div>

						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot
					@endcomponent

				</form>

				<form method="POST" action="{{ route('roles.update', $role->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Update Details
						@endslot

						<div class="card-body">		

							@include('roles.partials.form')

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