@extends('layouts.app')

@section('content')

	{{-- Main Title and Area Navigation --}}
	@component('partials.sections.hero.container')
		@slot('title')
			Calendars
		@endslot

		@slot('footer')

			@component('partials.sections.hero.tab-item')
				Calendars
				@slot('path')
					{{ route('calendars.index') }}
				@endslot
			@endcomponent

		@endslot
	@endcomponent

	@component('partials.nav')
		@slot('navLeft')

			@component('partials.nav-item')
				List
				@slot('path')
					{{ route('calendars.index') }}
				@endslot
			@endcomponent

		@endslot
		@slot('navRight')

			@component('partials.nav-item')
				Create Calendar
				@slot('path')
					{{ route('calendars.create') }}
				@endslot
			@endcomponent

		@endslot
	@endcomponent

	@yield('sub-content')

@endsection