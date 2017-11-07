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

				<div class="card mb-3">

					@component('partials.card-header')
						Unsent and/or Unpaid Statements
						@slot('small')
							Ready statements are sent every day at 
							<span class="text-warning">
								<b>{!! get_setting('statement_send_time', 'Not set, update application settings') !!}</b>
							</span>
						@endslot
					@endcomponent

					@include('statements.partials.unsent-statements-table', ['statements' => $unsent_statements])

				</div>

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