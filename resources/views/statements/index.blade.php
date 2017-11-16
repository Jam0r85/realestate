@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			{{ $title }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

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

		@if (isset($unsent_statements))
			@if (count($unsent_statements) && $statements->currentPage() == 1)			

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

			@endif
		@endif

		@include('statements.partials.sent-statements-table')

	@endcomponent

@endsection