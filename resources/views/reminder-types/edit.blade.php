@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('reminder-types.show', $type->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $type->name }}
		@endcomponent

		@component('partials.sub-header')
			Edit Reminder Type
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('reminder-types.update', $type->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}	

					<div class="card mb-3">

						@component('partials.card-header')
							Update Details
						@endcomponent

						<div class="card-body">		

							@component('partials.form-group')
								@slot('label')
									Name
								@endslot
								<input type="text" name="name" id="name" class="form-control" value="{{ old('name') ?? $type->name }}">
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Description
								@endslot
								<textarea name="description" id="description" rows="5" class="form-control">{{ old('description') ?? $type->description }}</textarea>
							@endcomponent

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