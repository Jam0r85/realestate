@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('tenancies.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-plus"></i> New Tenancy
		</a>

		@component('partials.header')
			{{ isset($title) ? $title : 'Tenancies List' }}
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		{{-- Tenancies Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('tenancies.search') }}
			@endslot
			@if (session('tenancies_search_term'))
				@slot('search_term')
					{{ session('tenancies_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Tenancies Search --}}

		<ul class="nav nav-pills">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ request('service') ?? 'Services' }}
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item @if (!request('service')) active @endif" href="{{ Filter::link('tenancies.index', ['service' => null]) }}">
						All Services
					</a>
					<div class="dropdown-divider"></div>
					@foreach (services() as $service)
						<a class="dropdown-item @if (request('service') == $service->slug) active @endif" href="{{ Filter::link('tenancies.index', ['service' => $service->slug]) }}">
							{{ $service->name }}
						</a>
					@endforeach
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ request('month') ?? 'Month' }}
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item @if (!request('month')) active @endif" href="{{ Filter::link('tenancies.index', ['month' => null]) }}">
						Any Month
					</a>
					<div class="dropdown-divider"></div>
					@foreach (months() as $month)
						<a class="dropdown-item @if (request('month') == $month) active @endif" href="{{ Filter::link('tenancies.index', ['month' => $month]) }}">
							{{ $month }}
						</a>
					@endforeach
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ request('year') ?? 'Year' }}
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item @if (!request('year')) active @endif" href="{{ Filter::link('tenancies.index', ['year' => null]) }}">
						Any Year
					</a>
					<div class="dropdown-divider"></div>
					@foreach (years('App\Tenancy', 'started_on') as $year)
						<a class="dropdown-item @if (request('year') == $year) active @endif" href="{{ Filter::link('tenancies.index', ['year' => $year]) }}">
							{{ $year }}
						</a>
					@endforeach
				</div>
			</li>

			<li class="nav-item">
				<a class="nav-link @if (request('overdue')) active @endif" href="{{ Filter::link('tenancies.index', ['overdue' => true]) }}">
					Overdue
				</a>
			</li>

			{!! Filter::clearButton() !!}

		</ul>

		@include('tenancies.partials.tenancies-table')
		@include('partials.pagination', ['collection' => $tenancies])

	@endcomponent

@endsection