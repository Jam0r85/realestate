@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					{{ $title }}
					<a href="{{ route('invoices.create') }}" class="btn btn-primary">
						<i class="fa fa-plus"></i> New Invoice
					</a>
				</h1>
			</div>

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

		</div>
	</section>

	@if (isset($unpaid_invoices))
		@if (count($unpaid_invoices) && $invoices->currentPage() == 1)
			<section class="section">
				<div class="container">

					<div class="page-title">
						<h3 class="text-danger">
							Unpaid Invoices
						</h3>
						<h5 class="text-muted">
							Invoices with a balance of {{ currency(0) }} will be marked as paid shortly.
						</h5>
					</div>

					<div class="row">
						<div class="col">
							@include('invoices.partials.unpaid-invoices-table', ['invoices' => $unpaid_invoices])
						</div>
					</div>

				</div>
			</section>
		@endif
	@endif

	<section class="section">
		<div class="container">

			@if (!session('invoices_search_term'))
				<div class="page-title">
					<h3 class="text-success">
						Paid Invoices
					</h3>
				</div>
			@endif

			<div class="row">
				<div class="col">
					@include('invoices.partials.paid-invoices-table')
				</div>
			</div>

		</div>
	</section>

@endsection