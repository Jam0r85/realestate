@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('maintenances.show', $issue->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $issue->name }}
		@endcomponent

		@component('partials.sub-header')
			Edit Maintenance Issue
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				@can('update', $issue)
					<form method="POST" action="{{ route('maintenances.update', $issue->id) }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}	

						@component('partials.card')
							@slot('header')
								Issue Details
							@endslot
							@slot('body')

								@include('maintenances.partials.form')

							@endslot
							@slot('footer')
								@component('partials.save-button')
									Save Changes
								@endcomponent
							@endslot
						@endcomponent

					</form>
				@else
					@component('partials.card')
						@slot('header')
							Issue Details
						@endslot
						@slot('body')
							@component('partials.alerts.warning')
								@icon('warning') You do not have the required permissions to do this.
							@endcomponent
						@endslot
					@endcomponent
				@endcan

			</div>
			<div class="col-12 col-lg-6">


			</div>
		</div>

	@endcomponent

@endsection