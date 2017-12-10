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
			{!! (new Filter())->yearDropdown('App\Tenancy') !!}

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

			<li class="nav-item">
				<a class="nav-link @if (request('vacated')) active @endif" href="{{ request('vacated') ? Filter::link(['vacated' => null]) : Filter::link(['vacated' => true]) }}">
					Vacated
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link @if (request('vacating')) active @endif" href="{{ request('vacating') ? Filter::link(['vacating' => null]) : Filter::link(['vacating' => true]) }}">
					Vacating
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link @if (request('archived')) active @endif" href="{{ request('archived') ? Filter::link(['archived' => null]) : Filter::link(['archived' => true]) }}">
					Archived
				</a>
			</li>

			{!! Filter::clearButton() !!}

		</ul>

		@include('tenancies.partials.tenancies-table')
		@include('partials.pagination', ['collection' => $tenancies])

	@endcomponent

@endsection