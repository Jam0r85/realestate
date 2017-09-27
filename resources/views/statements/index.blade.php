@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>{{ $title }}</h1>
			</div>

			{{-- Users Search --}}
			@component('partials.bootstrap.page-search')
				@slot('route')
					{{ route('statements.search') }}
				@endslot
				@if (session('statements_search_term'))
					@slot('search_term')
						{{ session('statements_search_term') }}
					@endslot
				@endif
			@endcomponent
			{{-- End of Users Search --}}

		</div>
	</section>

	@if (isset($unsent_statements))
		@if (count($unsent_statements) && $statements->currentPage() == 1)
			<section class="section">
				<div class="container">
					<h3 class="text-danger">
						Unsent and/or Unpaid Statements
					</h3>
					<div class="row">
						<div class="col">
							@include('statements.partials.unsent-statements-table', ['statements' => $unsent_statements])
						</div>
					</div>
				</div>
			</section>
		@endif
	@endif

	<section class="section">
		<div class="container">

			@if (!session('statements_search_term'))
				<div class="page-title">
					<h3 class="text-success">
						Sent Statements
					</h3>
				</div>
			@endif

			<div class="row">
				<div class="col">
					@include('statements.partials.sent-statements-table')
				</div>
			</div>

		</div>
	</section>

@endsection