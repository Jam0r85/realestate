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

		@if (isset($unpaid_invoices))
			@if (count($unpaid_invoices) && $invoices->currentPage() == 1)

				<div class="card mb-3">

					@component('partials.card-header')
						Unpaid Invoices
						@slot('small')
							{{ currency($unpaid_invoices->sum('total')) }}
						@endslot
					@endcomponent

					@include('invoices.partials.invoices-table', ['invoices' => $unpaid_invoices])

				</div>

			@endif
		@endif

		@include('invoices.partials.invoices-table')

		@if (!request()->segment(2))
			@include('partials.pagination', ['collection' => $invoices->appends(request()->input())])
		@endif
	
	@endcomponent

@endsection