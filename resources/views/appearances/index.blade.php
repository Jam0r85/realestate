@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			<a href="{{ route('appearances.create') }}" class="btn btn-primary">
				<i class="fa fa-plus"></i> New Appearance
			</a>
		</div>

		@component('partials.header')
			{{ isset($title) ? $title : 'Appearances List' }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col-12 col-md-4 col-lg-3 col-xl-2">

				@if (isset($sections))
					<div class="nav flex-column nav-pills mb-5" id="v-pills-tab" role="tablist" aria-orientation="vertical">

						@foreach ($sections as $key)
							<a class="nav-link @if (request('section') == str_slug($key)) active @elseif (!request('section') && $loop->first) active @endif" id="v-pills-{{ str_slug($key) }}-tab" data-toggle="pill" href="#v-pills-{{ str_slug($key) }}" role="tab">
								{{ $key }}
							</a>
						@endforeach

						<div class="dropdown-divider"></div>

						@foreach (sections() as $section)
							<a class="nav-link @if (request('section') == $section->slug) active @endif" id="v-pills-{{ $section->slug }}-tab" data-toggle="pill" href="#v-pills-{{ $section->slug }}" role="tab">
								{{ $section->name }}
							</a>
						@endforeach

					</div>
				@endif

			</div>
			<div class="col-12 col-md-8 col-lg-9 col-xl-10">

				<div class="tab-content" id="v-pills-tabContent">

					@if (isset($sections))
						@foreach ($sections as $key)
							@include('appearances.sections.index.' . str_slug($key))
						@endforeach
					@endif

				</div>

			</div>
		</div>

	@endcomponent

@endsection