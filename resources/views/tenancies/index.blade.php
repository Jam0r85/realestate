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

		@include('partials.index-search', ['route' => 'tenancies.search', 'session' => 'tenancy_search_term'])

		<ul class="nav nav-pills">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ request('service') ? slug_to_name(request('service')) : 'Services' }}
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item @if (!request('service')) active @endif" href="{{ Filter::link(['service' => null]) }}">
						All Services
					</a>
					<div class="dropdown-divider"></div>
					@foreach (services() as $service)
						<a class="dropdown-item @if (request('service') == $service->slug) active @endif" href="{{ Filter::link(['service' => $service->slug]) }}">
							{{ $service->name }}
						</a>
					@endforeach
				</div>
			</li>

			{!! (new Filter())->monthDropdown() !!}
			{!! (new Filter())->yearDropdown('App\Tenancy', 'started_on') !!}

			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ request('status') ? slug_to_name(request('status')) : 'Status' }}
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item @if (!request('status')) active @endif" href="{{ Filter::link(['status' => null]) }}">
						All Statuses
					</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item @if (request('status') == 'starting') active @endif" href="{{ Filter::link(['status' => 'starting']) }}">
						Starting
					</a>
					<a class="dropdown-item @if (request('status') == 'vacating') active @endif" href="{{ Filter::link(['status' => 'vacating']) }}">
						Vacating
					</a>
					<a class="dropdown-item @if (request('status') == 'vacated') active @endif" href="{{ Filter::link(['status' => 'vacated']) }}">
						Vacated
					</a>
				</div>
			</li>

			<li class="nav-item">
				<a class="nav-link @if (request('overdue')) active @endif" href="{{ request('overdue') ? Filter::link(['overdue' => null]) : Filter::link(['overdue' => true]) }}">
					Overdue
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link @if (request('has_rent_balance')) active @endif" href="{{ request('has_rent_balance') ? Filter::link(['has_rent_balance' => null]) : Filter::link(['has_rent_balance' => true]) }}">
					Has Rent
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link @if (request('owes_rent')) active @endif" href="{{ request('owes_rent') ? Filter::link(['owes_rent' => null]) : Filter::link(['owes_rent' => true]) }}">
					Owes Rent
				</a>
			</li>

			{!! Filter::archivePill() !!}
			{!! Filter::clearButton() !!}

		</ul>

		@include('tenancies.partials.tenancies-table')
		@include('partials.pagination', ['collection' => $tenancies])

	@endcomponent

@endsection