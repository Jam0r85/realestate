@extends('layouts.app')

@section('content')

	@component('partials.sections.hero.container')

		@slot('title')
			{{ $branch->name }}
		@endslot

		@slot('footer')

			@component('partials.sections.hero.tab-item')
				Dashboard
				@slot('path')
					{{ route('branches.show', $branch->id) }}
				@endslot
			@endcomponent

		@endslot

	@endcomponent

	@component('partials.nav')
		@slot('navRight')

			@component('partials.nav-item')
				Back to Branches
				@slot('path')
					{{ route('settings.branches') }}
				@endslot
			@endcomponent

		@endslot
	@endcomponent

	@yield('sub-content')

@endsection