@php
	$sections = [
		'Active' => 'active',
		'Archived' => 'archived'
	];
@endphp

@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('users.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-user-plus"></i> Register User
		</a>

		@component('partials.header')
			{{ $title }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col-12 col-md-4 col-lg-3 col-xl-2">

				{{-- Users Search --}}
				@component('partials.bootstrap.page-search')
					@slot('route')
						{{ route('users.search') }}
					@endslot
					@if (session('users_search_term'))
						@slot('search_term')
							{{ session('users_search_term') }}
						@endslot
					@endif
				@endcomponent
				{{-- End of Users Search --}}

				<div class="nav flex-column nav-pills mb-5" id="v-pills-tab" role="tablist" aria-orientation="vertical">

					@foreach ($sections as $key => $value)
						<a class="nav-link @if (request('section') == str_slug($key)) active @elseif (!request('section') && $loop->first) active @endif" id="v-pills-{{ str_slug($key) }}-tab" data-toggle="pill" href="#v-pills-{{ str_slug($key) }}" role="tab">
							{{ $key }}
						</a>
					@endforeach

				</div>

			</div>
			<div class="col-12 col-md-8 col-lg-9 col-xl-10">

				<div class="tab-content" id="v-pills-tabContent">

					@foreach ($sections as $key => $value)
						@include('users.sections.index.' . str_slug($key))
					@endforeach

				</div>

			</div>
		</div>

	@endcomponent

@endsection