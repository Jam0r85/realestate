@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					{{ $title }}
					<a href="{{ route('tenancies.create') }}" class="btn btn-primary">
						<i class="fa fa-plus"></i> New Tenancy
					</a>
				</h1>
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

		</div>
	</section>

	<section class="section">
		<div class="container">

			@include('tenancies.partials.table')

		</div>
	</section>

@endsection