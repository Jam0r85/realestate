@extends('layouts.app')

@section('content')

	@component('partials.sections.hero.container')

		@slot('title')
			{{ $calendar->name }}
		@endslot

		@slot('footer')

			@component('partials.sections.hero.tab-item')
				Events
				@slot('path')
					{{ route('calendars.show', $calendar->id) }}
				@endslot
			@endcomponent
			@component('partials.sections.hero.tab-item')
				Calendar Settings
				@slot('path')
					{{ route('calendars.show', ['calendar' => $calendar->id, 'section' => 'settings']) }}
				@endslot
			@endcomponent

		@endslot

	@endcomponent

	@component('partials.nav')
		@slot('navLeft')

			@component('partials.nav-item')
				Diary View
				@slot('path')
					{{ route('calendars.show', $calendar->id) }}
				@endslot
			@endcomponent
			@component('partials.nav-item')
				Archived Events <span class="tag">{{ $archived_events }}</span>
				@slot('path')
					{{ route('calendars.show', ['id' => $calendar->id, 'section' => 'archived-events']) }}
				@endslot
			@endcomponent


		@endslot
		@slot('navRight')

			@component('partials.nav-item')
				Back to Calendars
				@slot('path')
					{{ route('calendars.index') }}
				@endslot
			@endcomponent

		@endslot
	@endcomponent

	@yield('sub-content')

@endsection