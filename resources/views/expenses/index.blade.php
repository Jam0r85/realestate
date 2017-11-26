@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('expenses.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-plus"></i> New Expense
		</a>

		@component('partials.header')
			Expenses List
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col-12 col-md-4 col-lg-3 col-xl-2">

				{{-- Expenses Search --}}
				@component('partials.bootstrap.page-search')
					@slot('route')
						{{ route('expenses.search') }}
					@endslot
					@if (session('expenses_search_term'))
						@slot('search_term')
							{{ session('expenses_search_term') }}
						@endslot
					@endif
				@endcomponent
				{{-- End of Expenses Search --}}

				@if (isset($sections))
					<div class="nav flex-column nav-pills mb-5" id="v-pills-tab" role="tablist" aria-orientation="vertical">

						@foreach ($sections as $key)
							<a class="nav-link @if (request('section') == str_slug($key)) active @elseif (!request('section') && $loop->first) active @endif" id="v-pills-{{ str_slug($key) }}-tab" data-toggle="pill" href="#v-pills-{{ str_slug($key) }}" role="tab">
								{{ $key }}
							</a>
						@endforeach

					</div>
				@endif

			</div>
			<div class="col-12 col-md-8 col-lg-9 col-xl-10">

				<div class="tab-content" id="v-pills-tabContent">

					@if (isset($sections))
						@foreach ($sections as $key)
							@include('expenses.sections.index.' . str_slug($key))
						@endforeach
					@endif

					@if (isset($searchResults))
						@include('expenses.partials.expenses-table', ['expenses' => $searchResults])
					@endif

				</div>

			</div>
		</div>

	@endcomponent

@endsection