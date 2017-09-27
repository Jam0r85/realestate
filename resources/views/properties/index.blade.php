@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					{{ $title }}
					<a href="{{ route('properties.create') }}" class="btn btn-primary">
						<i class="fa fa-plus"></i> New Property
					</a>
				</h1>
			</div>

			{{-- Properties Search --}}
			@component('partials.bootstrap.page-search')
				@slot('route')
					{{ route('properties.search') }}
				@endslot
				@if (session('properties_search_term'))
					@slot('search_term')
						{{ session('properties_search_term') }}
					@endslot
				@endif
			@endcomponent
			{{-- End of Properties Search --}}

		</div>
	</section>

	<section class="section">
		<div class="container">

			@include('properties.partials.table')

		</div>
	</section>

@endsection