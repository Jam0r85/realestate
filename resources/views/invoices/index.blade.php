@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('invoices.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-plus"></i> New Invoice
		</a>

		@component('partials.header')
			{{ $title }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		{{-- Invoices Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('invoices.search') }}
			@endslot
			@if (session('invoices_search_term'))
				@slot('search_term')
					{{ session('invoices_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Invoices Search --}}

		@if (isset($sections))
			<div class="nav nav-pills" id="v-pills-tab" role="tablist">

				<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{ request('group') ?? 'Group' }}
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item @if (!request('group')) active @endif" href="{{ Menu::filterRoute('invoices.index', ['group' => null]) }}">
							All Groups
						</a>
						<div class="dropdown-divider"></div>
						@foreach (invoiceGroups() as $group)
							<a class="dropdown-item @if (request('group') == $group->slug) active @endif" href="{{ Menu::filterRoute('invoices.index', ['group' => $group->slug]) }}">
								{{ $group->name }}
							</a>
						@endforeach
					</div>
				</div>

				<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{ request('month') ?? 'Month' }}
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item @if (!request('month')) active @endif" href="{{ Menu::filterRoute('invoices.index', ['month' => null]) }}">
							Any Month
						</a>
						<div class="dropdown-divider"></div>
						@foreach (months() as $month)
							<a class="dropdown-item @if (request('month') == $month) active @endif" href="{{ Menu::filterRoute('invoices.index', ['month' => $month]) }}">
								{{ $month }}
							</a>
						@endforeach
					</div>
				</div>

				<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{ request('year') ?? 'Year' }}
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item @if (!request('year')) active @endif" href="{{ Menu::filterRoute('invoices.index', ['year' => null]) }}">
							Any Year
						</a>
						<div class="dropdown-divider"></div>
						@foreach (years('App\Invoice') as $year)
							<a class="dropdown-item @if (request('year') == $year) active @endif" href="{{ Menu::filterRoute('invoices.index', ['year' => $year]) }}">
								{{ $year }}
							</a>
						@endforeach
					</div>
				</div>

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
					@include('invoices.sections.index.' . str_slug($key))
				@endforeach
			@endif

			@if (isset($searchResults))
				@include('invoices.partials.invoices-table', ['invoices' => $searchResults])
			@endif

		</div>
	
	@endcomponent

@endsection