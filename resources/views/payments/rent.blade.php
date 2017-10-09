@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')
		<div class="page-title">
			<h1>
				{{ $title }}
			</h1>
		</div>

		{{-- Payments Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('payments.search') }}
			@endslot
			@if (session('payments_search_term'))
				@slot('search_term')
					{{ session('payments_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Payments Search --}}

	@endcomponent

	@component('partials.bootstrap.section-with-container')
		@include('payments.partials.rent-payments-table')
	@endcomponent

@endsection