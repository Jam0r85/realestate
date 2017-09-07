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

			<div class="page-search">
				<form role="form" method="POST" action="{{ route('invoices.search') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<div class="input-group">
							{{-- Clear Search Button --}}
							@if (session('invoices_search_term'))
								<span class="input-group-btn">
									<button type="submit" class="btn btn-danger" name="clear_search" value="true">
										<i class="fa fa-trash"></i> Clear
									</button>
								</span>
							@endif
							<input type="text" name="search_term" class="form-control" placeholder="Search for..." value="{{ session('invoices_search_term') }}" />
							<span class="input-group-btn">
								<button type="submit" class="btn btn-secondary">
									<i class="fa fa-search"></i> Search
								</button>
							</span>
						</div>
					</div>
				</form>
			</div>

		</div>
	</section>

	@if (count($unpaid_invoices))

		<section class="section">
			<div class="container">

				<div class="page-title">
					<h3 class="text-danger">
						Unpaid Invoices
					</h3>
				</div>

				<div class="row">
					<div class="col">
						@include('invoices.partials.unpaid-invoices-table', ['invoices' => $unpaid_invoices])
					</div>
				</div>

			</div>
		</section>

	@endif

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h3 class="text-success">
					Paid Invoices
				</h3>
			</div>

			<div class="row">
				<div class="col">
					@include('invoices.partials.paid-invoices-table', ['invoices' => $paid_invoices])
				</div>
			</div>

		</div>
	</section>

@endsection