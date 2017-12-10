@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('invoices.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-plus"></i> New Invoice
		</a>

		@component('partials.header')
			Invoices List
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

		<ul class="nav nav-pills">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ request('group') ? slug_to_name(request('group')) : 'Group' }}
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item @if (!request('group')) active @endif" href="{{ Filter::link(['group' => null]) }}">
						All Groups
					</a>
					<div class="dropdown-divider"></div>
					@foreach (invoiceGroups() as $group)
						<a class="dropdown-item @if (request('group') == $group->slug) active @endif" href="{{ Filter::link(['group' => $group->slug]) }}">
							{{ $group->name }}
						</a>
					@endforeach
				</div>
			</li>
			{!! (new Filter())->monthDropdown() !!}
			{!! (new Filter())->yearDropdown('App\Invoice') !!}
			{!! Filter::paidPill() !!}
			{!! Filter::unpaidPill() !!}
			{!! Filter::archivePill() !!}
			{!! Filter::clearButton() !!}
		</ul>

		@include('invoices.partials.invoices-table')
		@include('partials.pagination', ['collection' => $invoices])
	
	@endcomponent

@endsection