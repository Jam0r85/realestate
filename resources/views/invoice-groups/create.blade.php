@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Invoice Group
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@if (!commonCount('branches'))
			@component('partials.alerts.warning')
				@icon('warning') Please create a <a href="{{ route('branches.create') }}">branch</a> before you create an invoice group.
			@endcomponent
		@else

			@include('partials.errors-block')

			<form method="POST" action="{{ route('invoice-groups.store') }}">
				{{ csrf_field() }}

				@component('partials.card')
					@slot('header')
						Group Details
					@endslot

					@slot('body')

						@component('partials.form-group')
							@slot('label')
								Branch
							@endslot
							<select class="form-control" name="branch_id" id="branch_id" required>
								<option value="" selected>Please select..</option>
								@foreach(common('branches') as $branch)
									<option value="{{ $branch->id }}">{{ $branch->name }}</option>
								@endforeach
							</select>
						@endcomponent

						@include('invoice-groups.partials.form')

					@endslot

					@slot('footer')
						@component('partials.save-button')
							Create Group
						@endcomponent
					@endslot

				@endcomponent

			</form>

		@endif

	@endcomponent

@endsection