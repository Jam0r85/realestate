@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('branches.show', $branch->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $branch->name }}
		@endcomponent

		@component('partials.sub-header')
			Edit Branch
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('branches.update', $branch->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Branch Details
						@endslot

						@slot('body')	

							@include('branches.partials.form')

						@endslot

						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot

					@endcomponent

				</form>

			</div>
			<div class="col-12 col-lg-6">

				@if ($branch->deleted_at)

					<form method="POST" action="{{ route('branches.restore', $branch->id) }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}

						@component('partials.card')
							@slot('header')
								Restore Branch
							@endslot
							@slot('footer')
								@include('partials.forms.restore-button')
							@endslot
						@endcomponent

					</form>

					<form method="POST" action="{{ route('branches.forceDestroy', $branch->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						@component('partials.card')
							@slot('header')
								Destroy Branch
							@endslot
							@slot('footer')
								@include('partials.forms.destroy-button')
							@endslot
						@endcomponent

					</form>

				@else

					<form method="POST" action="{{ route('branches.destroy', $branch->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						@component('partials.card')
							@slot('header')
								Delete Branch
							@endslot
							@slot('footer')
								@include('partials.forms.delete-button')
							@endslot
						@endcomponent

					</form>

				@endif

			</div>
		</div>

	@endcomponent

@endsection