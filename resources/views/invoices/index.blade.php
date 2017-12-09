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
						Filter Group
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item @if (!request('group')) active @endif" href="{{ route('invoices.index') }}">
							All Groups
						</a>
						@foreach (invoiceGroups() as $group)
							<a class="dropdown-item @if (request('group') == $group->slug) active @endif" href="invoices?group={{ $group->slug }}">
								{{ $group->name }}
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