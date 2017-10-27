@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			@component('partials.header')
				{{ $title }}
			@endcomponent

		</div>

		{{-- Payments Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('rent-payments.search') }}
			@endslot
			@if (session('rent_payments_search_term'))
				@slot('search_term')
					{{ session('rent_payments_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Payments Search --}}

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('payments.partials.rent-payments-table')

	@endcomponent

@endsection