@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Tenancy #{{ $agreement->tenancy_id }}
				@slot('url')
					{{ route('tenancies.show', $agreement->tenancy_id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Agreement #{{ $agreement->id }}
		@endcomponent

		@component('partials.sub-header')
			Edit the Tenancy Agreement
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('agreements.update', $agreement->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Agreements Details
						@endslot

						<div class="card-body">

							@component('partials.form-group')
								@slot('label')
									Start Date
								@endslot
								<input type="date" name="starts_at" id="starts_at" class="form-control" value="{{ $agreement->starts_at->format('Y-m-d') }}" />
							@endcomponent

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

				@if ($agreement->deleted_at)

					@component('partials.card')
						@slot('header')
							Restore Agreement
						@endslot

						<div class="card-body">

							@component('partials.alerts.warning')
								You cannot restore or destroy an archived agreement.
							@endcomponent

						</div>
					@endcomponent

				@else

					<form method="POST" action="{{ route('agreements.forceDestroy', $agreement->id) }}">
						{{ csrf_field() }}
						{{ method_field('delete') }}

						@component('partials.card')
							@slot('header')
								Destroy Agreement
							@endslot

							@slot('footer')
								@component('partials.save-button')
									Destroy Invoice
								@endcomponent
							@endslot
						@endcomponent

					</form>

				@endif

			</div>
		</div>

	@endcomponent

@endsection