@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			User Logins
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@if (isset($sections))
			<div class="nav nav-pills" id="v-pills-tab" role="tablist">

				@foreach ($sections as $key)
					<a class="nav-link @if (request('section') == str_slug($key)) active @elseif (!request('section') && $loop->first) active @endif" id="v-pills-{{ str_slug($key) }}-tab" data-toggle="pill" href="#v-pills-{{ str_slug($key) }}" role="tab">
						{{ $key }}
					</a>
				@endforeach

			</div>
		@endif

		<div class="tab-content" id="v-pills-tabContent">

			@if (isset($sections))
				@foreach ($sections as $key)
					@include('user-logins.sections.index.' . str_slug($key))
				@endforeach
			@endif

		</div>

	@endcomponent

@endsection