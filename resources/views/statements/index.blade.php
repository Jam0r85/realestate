@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			@component('partials.header')
				{{ $title }}
			@endcomponent

		</div>

		{{-- Statements search form --}}
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
		{{-- End statements search form --}}

	@endcomponent

	@if (isset($unsent_statements))
		@if (count($unsent_statements) && $statements->currentPage() == 1)

			@component('partials.bootstrap.section-with-container')

				<div class="page-title">

					@component('partials.sub-header')
						Unsent and/or Unpaid Statements
					@endcomponent

				</div>

				<form method="POST" action="{{ route('statements.send') }}">
					{{ csrf_field() }}

					@include('statements.partials.unsent-statements-table', ['statements' => $unsent_statements])

					<button type="submit" class="btn btn-primary">
						<i class="fa fa-envelope-open"></i> Send Statements
					</button>

				</form>

			@endcomponent

		@endif
	@endif

	@component('partials.bootstrap.section-with-container')

		@if (!session('statements_search_term'))
			<div class="page-title">

				@component('partials.sub-header')
					Sent Statements
				@endcomponent

			</div>
		@endif

		@include('statements.partials.sent-statements-table')

	@endcomponent

@endsection