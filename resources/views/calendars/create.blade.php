@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Calendar
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@if (!commonCount('branches'))
			@component('partials.alerts.warning')
				@icon('warning') Please create a <a href="{{ route('branches.create') }}">branch</a> before you create a calendar.
			@endcomponent
		@else

			@include('partials.errors-block')

			<form method="POST" action="{{ route('calendars.store') }}">
				{{ csrf_field() }}

				@component('partials.card')
					@slot('body')

						@include('calendars.partials.form')

					@endslot

					@slot('footer')
						@component('partials.save-button')
							Create Calendar
						@endcomponent
					@endslot
				@endcomponent

			</form>

		@endif

	@endcomponent

@endsection