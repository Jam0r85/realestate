@extends('layouts.app')

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			{{ $user->name }}
		@endslot

		@if ($user->trashed())
			@slot('subTitle')
				User is Archived
			@endslot
			@slot('style')
				is-dark
			@endslot
		@endif

	@endcomponent

	@component('partials.nav')
		@slot('navRight')

			@component('partials.nav-item')
				Back to Users
				@slot('path')
					{{ route('users.index') }}
				@endslot
			@endcomponent

		@endslot
	@endcomponent

	@yield('sub-content')

@endsection