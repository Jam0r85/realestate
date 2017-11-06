@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('tenancies.create') }}" class="btn btn-primary float-right">
				<i class="fa fa-plus"></i> New Tenancy
			</a>

			@component('partials.header')
				{{ $title }}
			@endcomponent

			<div class="btn-group" role="group">
				<a href="{{ route('tenancies-list.index') }}" class="btn btn-sm {{ !Request::segment('2') ? 'btn-primary' : 'btn-secondary' }}">
					All Tenancies
				</a>
				<a href="{{ route('tenancies-list.index', 'overdue') }}" class="btn btn-sm {{ Request::segment('2') == 'overdue' ? 'btn-primary' : 'btn-secondary' }}">
					Overdue
					<span class="badge badge-light">
						{{ App\Tenancy::isOverdue()->count() }}
					</span>
				</a>
				<a href="{{ route('tenancies-list.index', 'has-rent') }}" class="btn btn-sm {{ Request::segment('2') == 'has-rent' ? 'btn-primary' : 'btn-secondary' }}">
					<span class="badge badge-light">
						{{ App\Tenancy::hasRent()->count() }}
					</span>
					Has Rent
				</a>
				<a href="{{ route('tenancies-list.index', 'owes-rent') }}" class="btn btn-sm {{ Request::segment('2') == 'owes-rent' ? 'btn-primary' : 'btn-secondary' }}">
					<span class="badge badge-light">
						{{ App\Tenancy::owesRent()->count() }}
					</span>
					Owes Rent
				</a>
			</div>

		</div>

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

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@if (Request::segment(2) == 'overdue')
			@include('tenancies.partials.overdue-tenancies-table')
		@else
			@include('tenancies.partials.tenancies-table')
		@endif

		@include('partials.pagination', ['collection' => $tenancies])

	@endcomponent

@endsection